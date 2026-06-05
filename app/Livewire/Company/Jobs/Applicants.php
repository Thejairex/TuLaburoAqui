<?php

namespace App\Livewire\Company\Jobs;

use App\Models\JobApplication;
use App\Models\JobPost;
use App\Models\Review;
use App\Services\ConversationService;
use App\Services\JobApplicationService;
use App\Services\ReviewService;
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

    public bool $showReviewModal = false;

    public ?string $reviewApplicationId = null;

    public int $reviewRating = 5;

    public string $reviewComment = '';

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

    public function openReviewModal(string $applicationId): void
    {
        $this->reviewApplicationId = $applicationId;
        $this->reviewRating = 5;
        $this->reviewComment = '';
        $this->showReviewModal = true;
    }

    public function submitReview(): void
    {
        $this->validate([
            'reviewRating' => 'required|integer|min:1|max:5',
            'reviewComment' => 'nullable|string|max:2000',
        ]);

        $application = JobApplication::where('job_post_id', $this->jobPost->id)
            ->findOrFail($this->reviewApplicationId);

        try {
            app(ReviewService::class)->createReview(
                $application,
                Auth::user(),
                $this->reviewRating,
                $this->reviewComment ?: null,
                'employer_to_candidate',
            );

            $this->showReviewModal = false;
            $this->reviewApplicationId = null;

            Flux::toast(variant: 'success', text: 'Calificación enviada.');
        } catch (\RuntimeException $e) {
            Flux::toast(variant: 'filled', text: $e->getMessage());
        }
    }

    public function render()
    {
        $applications = JobApplication::where('job_post_id', $this->jobPost->id)
            ->with(['user.workerProfile', 'user.media', 'conversation', 'reviews'])
            ->latest()
            ->get();

        $userReviewIds = Review::where('reviewer_user_id', Auth::id())
            ->whereIn('job_application_id', $applications->pluck('id'))
            ->pluck('job_application_id')
            ->toArray();

        return view('livewire.company.jobs.applicants', [
            'applications' => $applications,
            'jobPost' => $this->jobPost,
            'userReviewIds' => $userReviewIds,
        ]);
    }
}
