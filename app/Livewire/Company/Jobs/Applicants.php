<?php

namespace App\Livewire\Company\Jobs;

use App\Models\JobApplication;
use App\Models\JobPost;
use App\Services\ConversationService;
use App\Services\JobApplicationService;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Candidatos')]
class Applicants extends Component
{
    public JobPost $jobPost;

    public function mount(JobPost $jobPost): void
    {
        $company = Auth::user()->companyMemberships()->with('company')->first()?->company;

        abort_unless($company !== null, 403);
        abort_unless($jobPost->company_id === $company->id, 403);

        $this->jobPost = $jobPost->load('company', 'skills');
    }

    public function changeStatus(string $applicationId, string $status): void
    {
        $application = JobApplication::where('job_post_id', $this->jobPost->id)
            ->findOrFail($applicationId);

        app(JobApplicationService::class)->changeStatus($application, $status);

        Flux::toast(variant: 'success', text: 'Estado de la postulación actualizado.');
    }

    public function startConversation(string $applicationId): void
    {
        $application = JobApplication::where('job_post_id', $this->jobPost->id)
            ->findOrFail($applicationId);

        $conversation = app(ConversationService::class)
            ->startForApplication($application, Auth::user());

        $this->redirect(route('conversations.show', $conversation), navigate: true);
    }

    public function render()
    {
        $applications = JobApplication::where('job_post_id', $this->jobPost->id)
            ->with(['user.workerProfile', 'user.media', 'conversation'])
            ->latest()
            ->get();

        return view('livewire.company.jobs.applicants', [
            'applications' => $applications,
            'jobPost' => $this->jobPost,
        ]);
    }
}
