<?php

namespace App\Services;

use App\Models\JobApplication;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class JobApplicationService
{
    public function apply(JobPost $job, User $user, ?string $coverLetter = null): JobApplication
    {
        abort_unless($job->isPublished(), 400, 'La oferta no está disponible.');

        abort_unless($user->role === 'candidate', 403, 'Solo los candidatos pueden postularse.');

        $exists = JobApplication::where('job_post_id', $job->id)
            ->where('user_id', $user->id)
            ->exists();

        abort_if($exists, 409, 'Ya te postulaste a esta oferta.');

        return DB::transaction(function () use ($job, $user, $coverLetter) {
            $application = new JobApplication([
                'status' => 'submitted',
                'cover_letter' => $coverLetter,
                'applied_at' => now(),
            ]);

            $application->jobPost()->associate($job);
            $application->user()->associate($user);
            $application->match_score = $this->matchScore($job, $user);
            $application->save();

            return $application;
        });
    }

    public function changeStatus(JobApplication $application, string $status): void
    {
        if (! in_array($status, JobApplication::STATUSES, true)) {
            return;
        }

        if ($status === 'in_review' || $status === 'shortlisted' || $status === 'rejected') {
            $application->reviewed_at ??= now();
        }

        if ($status === 'hired') {
            $application->hired_at = now();
            $application->reviewed_at ??= now();
        }

        $application->status = $status;
        $application->save();
    }

    public function matchScore(JobPost $job, User $user): float
    {
        $jobSkills = $job->skills()->pluck('skills.id');
        $candidateSkills = $user->workerProfile?->skills()->pluck('skills.id') ?? collect();

        if ($jobSkills->isEmpty()) {
            return 0;
        }

        $intersection = $jobSkills->intersect($candidateSkills);

        return round(($intersection->count() / $jobSkills->count()) * 100, 2);
    }
}
