<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#[Fillable(
    [
        'job_application_id',
        'subject',
        'status',
        'last_message_at',
    ]
)]
class Conversation extends Model
{
    use HasUuids;

    protected function casts()
    {
        return [
            'last_message_at' => 'datetime',
        ];
    }

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class)->latest('created_at');
    }

    public function participants()
    {
        return $this->hasMany(ConversationParticipant::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
            ->withPivot('last_read_at')
            ->withTimestamps();
    }

    public function unreadCountFor(User $user): int
    {
        $participant = $this->participants()->where('user_id', $user->id)->first();

        if (! $participant) {
            return 0;
        }

        return $this->messages()
            ->where('sender_user_id', '!=', $user->id)
            ->where(function ($q) use ($participant) {
                $q->whereNull('read_at')
                    ->orWhere('created_at', '>', $participant->last_read_at);
            })
            ->count();
    }
}
