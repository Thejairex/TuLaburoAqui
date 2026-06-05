<?php

namespace App\Livewire\Applications;

use App\Models\JobApplication;
use App\Models\Review;
use App\Services\JobApplicationService;
use App\Services\ReviewService;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Mis postulaciones')]
class Index extends Component
{
    public bool $showReviewModal = false;

    public ?string $reviewApplicationId = null;

    public int $reviewRating = 5;

    public string $reviewComment = '';

    public function withdraw(string $applicationId): void
    {
        $application = JobApplication::forCandidate(Auth::id())
            ->findOrFail($applicationId);

        if ($application->status === 'withdrawn') {
            return;
        }

        app(JobApplicationService::class)->changeStatus($application, 'withdrawn');

        Flux::toast(text: 'Postulación retirada.');
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

        $application = JobApplication::forCandidate(Auth::id())
            ->findOrFail($this->reviewApplicationId);

        try {
            app(ReviewService::class)->createReview(
                $application,
                Auth::user(),
                $this->reviewRating,
                $this->reviewComment ?: null,
                'candidate_to_employer',
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
        $applications = JobApplication::forCandidate(Auth::id())
            ->with(['jobPost.company', 'conversation', 'reviews'])
            ->latest()
            ->get();

        $userReviewIds = Review::where('reviewer_user_id', Auth::id())
            ->whereIn('job_application_id', $applications->pluck('id'))
            ->pluck('job_application_id')
            ->toArray();

        return view('livewire.applications.index', compact('applications', 'userReviewIds'));
    }
}
