<?php

namespace App\Models;

use Database\Factories\JobPostFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'company_id',
    'created_by_user_id',
    'title',
    'description',
    'category',
    'seniority',
    'contract_type',
    'work_modality',
    'city',
    'province',
    'location',
    'salary_min',
    'salary_max',
    'salary_visible',
    'vacancies',
    'is_featured',
    'status',
    'published_at',
    'expires_at',
])]
class JobPost extends Model
{
    /** @use HasFactory<JobPostFactory> */
    use HasFactory, HasUuids;

    public const STATUSES = ['draft', 'published', 'paused', 'closed', 'expired'];

    protected function casts(): array
    {
        return [
            'salary_min' => 'decimal:2',
            'salary_max' => 'decimal:2',
            'salary_visible' => 'boolean',
            'is_featured' => 'boolean',
            'vacancies' => 'integer',
            'published_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_post_skills', 'job_post_id', 'skill_id')
            ->using(JobPostSkill::class)
            ->withPivot('required', 'priority')
            ->withTimestamps();
    }

    public function scopeForCompany(Builder $query, string $companyId): Builder
    {
        return $query->where('company_id', $companyId);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now())
            ->where(function (Builder $q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            });
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'draft' => 'Borrador',
            'published' => 'Publicada',
            'paused' => 'Pausada',
            'closed' => 'Cerrada',
            'expired' => 'Vencida',
            default => ucfirst((string) $this->status),
        };
    }

    /**
     * @return array{bg:string, text:string}
     */
    public function statusColor(): array
    {
        return match ($this->status) {
            'published' => ['bg' => '#dcfce7', 'text' => '#166534'],
            'draft' => ['bg' => '#e1e2e4', 'text' => '#526069'],
            'paused' => ['bg' => '#fef9c3', 'text' => '#854d0e'],
            'closed' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
            'expired' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
            default => ['bg' => '#e1e2e4', 'text' => '#526069'],
        };
    }
}
