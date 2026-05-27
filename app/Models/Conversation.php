<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

#[Fillable(
    [
        'job_application_id',
        'subject',
        'status',
        'last_message_at'
    ]
)]
class Conversation extends Model
{
    use HasUuids;
    protected function casts(){
        return [
            'last_message_at' => 'datetime',
        ];
    }

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }
}
