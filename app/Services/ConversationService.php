<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\JobApplication;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ConversationService
{
    public function startForApplication(JobApplication $application, User $initiator): Conversation
    {
        $existing = Conversation::where('job_application_id', $application->id)->first();

        if ($existing) {
            return $existing;
        }

        return DB::transaction(function () use ($application, $initiator) {
            $conversation = Conversation::create([
                'job_application_id' => $application->id,
                'subject' => $application->jobPost->title,
                'status' => 'open',
            ]);

            $participantIds = collect([
                $application->user_id,
                $initiator->id,
            ])->unique();

            foreach ($participantIds as $userId) {
                ConversationParticipant::create([
                    'conversation_id' => $conversation->id,
                    'user_id' => $userId,
                ]);
            }

            return $conversation;
        });
    }

    public function sendMessage(Conversation $conversation, User $sender, string $body): Message
    {
        return DB::transaction(function () use ($conversation, $sender, $body) {
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_user_id' => $sender->id,
                'body' => $body,
                'message_type' => 'text',
            ]);

            $conversation->update(['last_message_at' => now()]);

            ConversationParticipant::where('conversation_id', $conversation->id)
                ->where('user_id', $sender->id)
                ->update(['last_read_at' => now()]);

            return $message;
        });
    }

    public function markRead(Conversation $conversation, User $user): void
    {
        ConversationParticipant::where('conversation_id', $conversation->id)
            ->where('user_id', $user->id)
            ->update(['last_read_at' => now()]);
    }
}
