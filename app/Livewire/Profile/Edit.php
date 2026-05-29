<?php

namespace App\Livewire\Profile;

use App\Concerns\WorkerProfileValidationRules;
use App\Models\Skill;
use App\Models\WorkerProfile;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.profile')]
#[Title('Mi perfil')]
class Edit extends Component
{
    use WithFileUploads, WorkerProfileValidationRules;

    // User fields
    public string $name = '';

    public string $phone = '';

    // WorkerProfile fields
    public string $headline = '';

    public string $bio = '';

    public string $city = '';

    public string $province = '';

    public string $birth_date = '';

    public string $available_immediately = '';

    public string $work_modality = '';

    public ?int $years_experience = null;

    public ?int $salary_min = null;

    public ?int $salary_max = null;

    public string $salary_period = 'MTH';

    // File uploads
    public $avatar = null;

    public $cv = null;

    // Skills
    public array $selectedSkills = [];

    public array $availableSkills = [];

    public function mount(): void
    {
        $user = Auth::user();
        $profile = $user->workerProfile ?? WorkerProfile::create(['user_id' => $user->id]);

        $this->name = $user->name;
        $this->phone = $user->phone ?? '';

        $this->headline = $profile->headline ?? '';
        $this->bio = $profile->bio ?? '';
        $this->city = $profile->city ?? '';
        $this->province = $profile->province ?? '';
        $this->birth_date = $profile->birth_date ?? '';
        $this->available_immediately = $profile->available_immediately ?? '';
        $this->work_modality = $profile->work_modality ?? '';
        $this->years_experience = $profile->years_experience;
        $this->salary_min = $profile->salary_min;
        $this->salary_max = $profile->salary_max;
        $this->salary_period = $profile->salary_period ?? 'MTH';

        $this->selectedSkills = $profile->skills->map(fn ($s) => [
            'skill_id' => $s->id,
            'name' => $s->name,
            'level' => $s->pivot->level,
            'experience_years' => $s->pivot->experience_years,
        ])->toArray();

        $this->availableSkills = Skill::orderBy('name')->get(['id', 'name', 'category'])->toArray();
    }

    public function save(): void
    {
        $validated = $this->validate($this->workerProfileRules());

        $user = Auth::user();
        $profile = $user->workerProfile ?? WorkerProfile::create(['user_id' => $user->id]);

        $user->fill(['name' => $validated['name'], 'phone' => $validated['phone'] ?? null]);
        $user->save();

        $profile->fill([
            'headline' => $validated['headline'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'city' => $validated['city'] ?? null,
            'province' => $validated['province'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'available_immediately' => $validated['available_immediately'] ?? null,
            'work_modality' => $validated['work_modality'] ?? null,
            'years_experience' => $validated['years_experience'] ?? null,
            'salary_period' => $validated['salary_period'] ?? 'MTH',
            'salary_min' => $validated['salary_min'] ?? null,
            'salary_max' => $validated['salary_max'] ?? null,
        ]);
        $profile->save();

        if ($this->avatar) {
            $user->addMedia($this->avatar->getRealPath())
                ->usingFileName($this->avatar->getClientOriginalName())
                ->toMediaCollection('avatar');
            $this->avatar = null;
        }

        if ($this->cv) {
            $profile->addMedia($this->cv->getRealPath())
                ->usingFileName($this->cv->getClientOriginalName())
                ->toMediaCollection('cv');
            $this->cv = null;
        }

        $syncData = [];
        foreach ($this->selectedSkills as $skill) {
            $syncData[$skill['skill_id']] = [
                'level' => (int) ($skill['level'] ?? 2),
                'experience_years' => $skill['experience_years'] ?? null,
            ];
        }
        $profile->skills()->sync($syncData);

        $profile->is_profile_complete = $profile->calculateCompleteness() >= 70;
        $profile->save();

        Flux::toast(variant: 'success', text: __('Perfil actualizado correctamente.'));
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
            'level' => 2,
            'experience_years' => null,
        ];
    }

    public function removeSkill(string $skillId): void
    {
        $this->selectedSkills = collect($this->selectedSkills)
            ->reject(fn ($s) => $s['skill_id'] === $skillId)
            ->values()
            ->toArray();
    }

    public function deleteAvatar(): void
    {
        Auth::user()->clearMediaCollection('avatar');
        Flux::toast(text: __('Foto eliminada.'));
    }

    public function deleteCv(): void
    {
        Auth::user()->workerProfile?->clearMediaCollection('cv');
        Flux::toast(text: __('CV eliminado.'));
    }

    public function render()
    {
        $user = Auth::user()->load('workerProfile');
        $completeness = $user->workerProfile?->calculateCompleteness() ?? 0;

        return view('livewire.profile.edit', compact('completeness'));
    }
}
