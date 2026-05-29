<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#[Fillable(
    [
        'conversation_id',
        'user_id',
        'last_read_at',
    ]
)]
class ConversationParticipant extends Model
{
    use HasUuids;

    protected function casts()
    {
        return [
            'last_read_at' => 'datetime',
        ];
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
