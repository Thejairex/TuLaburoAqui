<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'job_application_id',
    'reviewer_user_id',
    'reviewed_user_id',
    'rating',
    'comment',
    'review_type',
    'is_visible',
])]
class Review extends Model
{
    use HasUuids;

    public const TYPES = ['employer_to_candidate', 'candidate_to_employer'];

    protected function casts(): array
    {
        return [
            'is_visible' => 'boolean',
            'rating' => 'integer',
        ];
    }

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_user_id');
    }

    public function reviewed()
    {
        return $this->belongsTo(User::class, 'reviewed_user_id');
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_visible', true);
    }

    public function scopeOfType(Builder $query, string $type): Builder
    {
        return $query->where('review_type', $type);
    }

    public function scopeFromReviewer(Builder $query, string $userId): Builder
    {
        return $query->where('reviewer_user_id', $userId);
    }

    public function scopeToReviewed(Builder $query, string $userId): Builder
    {
        return $query->where('reviewed_user_id', $userId);
    }
}
