<?php

namespace App\Services;

use App\Models\Company;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class JobPostService
{
    /**
     * @param  array<int, array{skill_id:string, required?:bool, priority?:int}>  $skills
     */
    public function create(Company $company, User $user, array $data, array $skills = []): JobPost
    {
        return DB::transaction(function () use ($company, $user, $data, $skills) {
            $job = new JobPost($data);
            $job->company_id = $company->id;
            $job->created_by_user_id = $user->id;
            $job->status = $data['status'] ?? 'draft';

            if ($job->status === 'published') {
                $job->published_at = now();
            }

            $job->save();
            $this->syncSkills($job, $skills);

            return $job;
        });
    }

    /**
     * @param  array<int, array{skill_id:string, required?:bool, priority?:int}>  $skills
     */
    public function update(JobPost $job, array $data, array $skills = []): JobPost
    {
        return DB::transaction(function () use ($job, $data, $skills) {
            $job->fill($data);
            $job->save();
            $this->syncSkills($job, $skills);

            return $job;
        });
    }

    public function changeStatus(JobPost $job, string $status): JobPost
    {
        if (! in_array($status, JobPost::STATUSES, true)) {
            return $job;
        }

        // Al publicar por primera vez, registrar la fecha de publicación.
        if ($status === 'published' && $job->published_at === null) {
            $job->published_at = now();
        }

        $job->status = $status;
        $job->save();

        return $job;
    }

    /**
     * @param  array<int, array{skill_id:string, required?:bool, priority?:int}>  $skills
     */
    private function syncSkills(JobPost $job, array $skills): void
    {
        $sync = [];

        foreach ($skills as $index => $skill) {
            $sync[$skill['skill_id']] = [
                'required' => (bool) ($skill['required'] ?? true),
                'priority' => (int) ($skill['priority'] ?? $index),
            ];
        }

        $job->skills()->sync($sync);
    }
}
