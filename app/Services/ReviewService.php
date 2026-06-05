<?php

namespace App\Services;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\Review;
use App\Models\User;

class ReviewService
{
    public function createReview(JobApplication $application, User $reviewer, int $rating, ?string $comment, string $reviewType): Review
    {
        abort_unless(in_array($reviewType, Review::TYPES, true), 400, 'Tipo de review inválido.');

        abort_if($rating < 1 || $rating > 5, 400, 'La calificación debe ser entre 1 y 5.');

        abort_unless(in_array($application->status, ['hired', 'rejected'], true), 400, 'Solo se puede calificar postulaciones finalizadas.');

        $isEmployer = $reviewer->role === 'employer';
        $isCandidate = $reviewer->role === 'candidate';

        if ($reviewType === 'employer_to_candidate' && ! $isEmployer) {
            abort(403, 'Solo el empleador puede calificar al candidato.');
        }

        if ($reviewType === 'candidate_to_employer' && ! $isCandidate) {
            abort(403, 'Solo el candidato puede calificar a la empresa.');
        }

        if ($isEmployer) {
            $company = $reviewer->companyMemberships()->first()?->company;
            abort_unless($company && $company->id === $application->jobPost->company_id, 403);
        }

        if ($reviewType === 'candidate_to_employer' && $application->user_id !== $reviewer->id) {
            abort(403, 'No puedes calificar esta postulación.');
        }

        $exists = Review::where('job_application_id', $application->id)
            ->where('reviewer_user_id', $reviewer->id)
            ->exists();

        abort_if($exists, 409, 'Ya calificaste esta postulación.');

        $reviewedUserId = $reviewType === 'employer_to_candidate'
            ? $application->user_id
            : $application->jobPost->company->members()->first()?->user_id;

        abort_unless($reviewedUserId, 400, 'No se pudo determinar el usuario a calificar.');

        $review = Review::create([
            'job_application_id' => $application->id,
            'reviewer_user_id' => $reviewer->id,
            'reviewed_user_id' => $reviewedUserId,
            'rating' => $rating,
            'comment' => $comment,
            'review_type' => $reviewType,
            'is_visible' => true,
        ]);

        if ($reviewType === 'employer_to_candidate') {
            $application->user->workerProfile?->touch();
        }

        if ($reviewType === 'candidate_to_employer') {
            $company = $application->jobPost->company;
            $this->recalculateCompanyRating($company);
        }

        return $review;
    }

    public function recalculateCompanyRating(Company $company): void
    {
        $ratings = Review::visible()
            ->where('review_type', 'candidate_to_employer')
            ->whereHas('jobApplication.jobPost', fn ($q) => $q->where('company_id', $company->id))
            ->pluck('rating')
            ->filter();

        $company->update([
            'avg_rating' => $ratings->isNotEmpty() ? $ratings->avg() : null,
            'ratings_count' => $ratings->count(),
        ]);
    }
}
