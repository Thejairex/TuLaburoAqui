<?php

namespace App\Livewire\Messages;

use App\Models\Conversation;
use App\Models\ConversationParticipant;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Mensajes')]
class Index extends Component
{
    public function render()
    {
        $conversationIds = ConversationParticipant::where('user_id', Auth::id())
            ->pluck('conversation_id');

        $conversations = Conversation::whereIn('id', $conversationIds)
            ->with(['jobApplication.jobPost.company', 'participants'])
            ->latest('last_message_at')
            ->get()
            ->map(function (Conversation $conversation) {
                $participant = $conversation->participants()
                    ->where('user_id', Auth::id())
                    ->first();

                $unread = $conversation->messages()
                    ->where('sender_user_id', '!=', Auth::id())
                    ->where(function ($q) use ($participant) {
                        $q->whereNull('read_at')
                            ->orWhere('created_at', '>', $participant->last_read_at);
                    })
                    ->count();

                $lastMessage = $conversation->messages()->latest()->first();

                $otherUser = $conversation->users()
                    ->where('users.id', '!=', Auth::id())
                    ->first();

                return (object) [
                    'conversation' => $conversation,
                    'unread' => $unread,
                    'lastMessage' => $lastMessage,
                    'otherUser' => $otherUser,
                ];
            });

        return view('livewire.messages.index', compact('conversations'));
    }
}
