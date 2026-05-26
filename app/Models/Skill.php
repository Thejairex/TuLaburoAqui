<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'slug', 'category'])]
class Skill extends Model
{
    use HasUuids;

    public function workerProfiles()
    {
        return $this->belongsToMany(WorkerProfile::class, 'worker_skills', 'skill_id', 'worker_profile_id')
            ->using(WorkerSkill::class)
            ->withPivot('level', 'experience_years')
            ->withTimestamps();
    }
}
