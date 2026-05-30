<?php

namespace App\Livewire\Company\Jobs;

use App\Concerns\JobPostValidationRules;
use App\Models\JobPost;
use App\Models\Skill;
use App\Services\JobPostService;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Oferta laboral')]
class Form extends Component
{
    use JobPostValidationRules;

    public ?JobPost $jobPost = null;

    public string $title = '';

    public string $description = '';

    public string $category = '';

    public string $seniority = '';

    public string $contract_type = '';

    public string $work_modality = '';

    public string $city = '';

    public string $province = '';

    public ?int $salary_min = null;

    public ?int $salary_max = null;

    public bool $salary_visible = false;

    public int $vacancies = 1;

    public array $selectedSkills = [];

    public array $availableSkills = [];

    public function mount(?JobPost $jobPost = null): void
    {
        $company = $this->company();

        if ($jobPost && $jobPost->exists) {
            abort_unless($jobPost->company_id === $company->id, 403);

            $this->jobPost = $jobPost;
            $this->title = $jobPost->title;
            $this->description = $jobPost->description ?? '';
            $this->category = $jobPost->category ?? '';
            $this->seniority = $jobPost->seniority ?? '';
            $this->contract_type = $jobPost->contract_type ?? '';
            $this->work_modality = $jobPost->work_modality ?? '';
            $this->city = $jobPost->city ?? '';
            $this->province = $jobPost->province ?? '';
            $this->salary_min = $jobPost->salary_min !== null ? (int) $jobPost->salary_min : null;
            $this->salary_max = $jobPost->salary_max !== null ? (int) $jobPost->salary_max : null;
            $this->salary_visible = (bool) $jobPost->salary_visible;
            $this->vacancies = $jobPost->vacancies ?? 1;

            $this->selectedSkills = $jobPost->skills->map(fn ($s) => [
                'skill_id' => $s->id,
                'name' => $s->name,
                'required' => (bool) $s->pivot->required,
            ])->toArray();
        }

        $this->availableSkills = Skill::orderBy('name')->get(['id', 'name', 'category'])->toArray();
    }

    public function addSkill(string $skillId): void
    {
        if (collect($this->selectedSkills)->pluck('skill_id')->contains($skillId)) {
            return;
        }

        $skill = collect($this->availableSkills)->firstWhere('id', $skillId);
        if (! $skill) {
            return;
        }

        $this->selectedSkills[] = [
            'skill_id' => $skillId,
            'name' => $skill['name'],
            'required' => true,
        ];
    }

    public function removeSkill(string $skillId): void
    {
        $this->selectedSkills = collect($this->selectedSkills)
            ->reject(fn ($s) => $s['skill_id'] === $skillId)
            ->values()
            ->toArray();
    }

    public function save(string $status = 'draft'): void
    {
        $validated = $this->validate($this->jobPostRules());

        $company = $this->company();
        $service = app(JobPostService::class);

        $data = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'category' => $validated['category'] ?: null,
            'seniority' => $validated['seniority'] ?: null,
            'contract_type' => $validated['contract_type'] ?: null,
            'work_modality' => $validated['work_modality'] ?: null,
            'city' => $validated['city'] ?: null,
            'province' => $validated['province'] ?: null,
            'salary_min' => $validated['salary_min'] ?? null,
            'salary_max' => $validated['salary_max'] ?? null,
            'salary_visible' => $validated['salary_visible'] ?? false,
            'vacancies' => $validated['vacancies'],
        ];

        if ($this->jobPost && $this->jobPost->exists) {
            $service->update($this->jobPost, $data, $this->selectedSkills);
            if ($status === 'published') {
                $service->changeStatus($this->jobPost, 'published');
            }
            Flux::toast(variant: 'success', text: __('Oferta actualizada.'));
        } else {
            $data['status'] = $status;
            $service->create($company, Auth::user(), $data, $this->selectedSkills);
            Flux::toast(variant: 'success', text: __('Oferta creada.'));
        }

        $this->redirect(route('company.jobs.index'), navigate: true);
    }

    private function company()
    {
        $company = Auth::user()->companyMemberships()->with('company')->first()?->company;

        abort_unless($company !== null, 403);

        return $company;
    }

    public function render()
    {
        return view('livewire.company.jobs.form');
    }
}
