<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
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
        'hired_at'
    ]
)]
class JobApplication extends Model
{
    use HasUuids;

    protected function casts(){
        return [
            'applied_at' => 'datetime',
            'reviewed_at' => 'datetime',
            'hired_at' => 'datetime',
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

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }
}
