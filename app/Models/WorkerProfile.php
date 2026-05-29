<?php

namespace App\Models;

use App\Services\WorkerProfileCompleteness;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable([
    'user_id', 'birth_date', 'dni_hash', 'city', 'province',
    'latitude', 'longitude', 'headline', 'bio', 'years_experience',
    'available_immediately', 'salary_period', 'salary_min', 'salary_max',
    'work_modality', 'is_profile_complete',
])]
class WorkerProfile extends Model implements HasMedia
{
    use HasUuids, InteractsWithMedia;

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cv')
            ->singleFile()
            ->acceptsMimeTypes(['application/pdf']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'worker_skills', 'worker_profile_id', 'skill_id')
            ->using(WorkerSkill::class)
            ->withPivot('level', 'experience_years')
            ->withTimestamps();
    }

    public function calculateCompleteness(): int
    {
        return app(WorkerProfileCompleteness::class)->percentage($this->user);
    }
}
