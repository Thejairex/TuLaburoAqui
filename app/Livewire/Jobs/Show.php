<?php

namespace App\Livewire\Jobs;

use App\Models\JobApplication;
use App\Models\JobPost;
use App\Services\JobApplicationService;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class Show extends Component
{
    public JobPost $jobPost;

    public ?JobApplication $application = null;

    public bool $showApplyModal = false;

    public string $coverLetter = '';

    public function mount(JobPost $jobPost): void
    {
        abort_unless($jobPost->isPublished(), 404);

        $this->jobPost = $jobPost->load(['company', 'skills']);

        if ($user = auth()->user()) {
            $this->application = JobApplication::where('job_post_id', $jobPost->id)
                ->where('user_id', $user->id)
                ->first();
        }
    }

    public function openApplyModal(): void
    {
        abort_unless(auth()->check(), 401);

        $this->coverLetter = '';
        $this->showApplyModal = true;
    }

    public function submitApplication(): void
    {
        $this->validate([
            'coverLetter' => 'nullable|string|max:5000',
        ]);

        try {
            $application = app(JobApplicationService::class)->apply(
                $this->jobPost,
                auth()->user(),
                $this->coverLetter ?: null,
            );

            $this->application = $application;
            $this->showApplyModal = false;

            Flux::toast(variant: 'success', text: 'Te postulaste correctamente.');
        } catch (\RuntimeException $e) {
            Flux::toast(variant: 'filled', text: $e->getMessage());
        }
    }

    public function title(): string
    {
        return $this->jobPost->title.' — TuLaburoAquí';
    }

    public function render()
    {
        return view('livewire.jobs.show');
    }
}
