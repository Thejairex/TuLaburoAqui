<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
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
    'created_at',
    'updated_at',
])]
#[Hidden([])]
class JobPost extends Model
{
    use HasUuids;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}
