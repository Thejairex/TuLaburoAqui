<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#[Fillable(
    [
        'job_post_id',
        'user_id',
        'status',
        'cover_letter',
        'source',
        'match_score',
        'applied_at',
        'reviewed_at',
        'hired_at',
    ]
)]
class JobApplication extends Model
{
    use HasUuids;

    public const STATUSES = ['submitted', 'in_review', 'shortlisted', 'rejected', 'hired', 'withdrawn'];

    protected function casts()
    {
        return [
            'applied_at' => 'datetime',
            'reviewed_at' => 'datetime',
            'hired_at' => 'datetime',
            'match_score' => 'decimal:2',
        ];
    }

    public function jobPost()
    {
        return $this->belongsTo(JobPost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conversation()
    {
        return $this->hasOne(Conversation::class);
    }

    public function scopeForCandidate(Builder $query, string $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForCompany(Builder $query, string $companyId): Builder
    {
        return $query->whereHas('jobPost', fn (Builder $q) => $q->where('company_id', $companyId));
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'submitted' => 'Postulado',
            'in_review' => 'En revisión',
            'shortlisted' => 'Preseleccionado',
            'rejected' => 'Rechazado',
            'hired' => 'Contratado',
            'withdrawn' => 'Retirado',
            default => ucfirst((string) $this->status),
        };
    }

    public function statusColor(): array
    {
        return match ($this->status) {
            'submitted' => ['bg' => '#e1e2e4', 'text' => '#526069'],
            'in_review' => ['bg' => '#fef9c3', 'text' => '#854d0e'],
            'shortlisted' => ['bg' => '#dcfce7', 'text' => '#166534'],
            'rejected' => ['bg' => '#fee2e2', 'text' => '#991b1b'],
            'hired' => ['bg' => '#dbeafe', 'text' => '#1e40af'],
            'withdrawn' => ['bg' => '#f3e8ff', 'text' => '#6b21a8'],
            default => ['bg' => '#e1e2e4', 'text' => '#526069'],
        };
    }
}
