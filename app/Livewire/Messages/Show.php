<?php

namespace App\Livewire\Messages;

use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Services\ConversationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Conversación')]
class Show extends Component
{
    public Conversation $conversation;

    public string $newMessage = '';

    public function mount(Conversation $conversation): void
    {
        $isParticipant = ConversationParticipant::where('conversation_id', $conversation->id)
            ->where('user_id', Auth::id())
            ->exists();

        abort_unless($isParticipant, 403);

        $this->conversation = $conversation->load([
            'jobApplication.jobPost.company',
            'users',
        ]);

        app(ConversationService::class)->markRead($conversation, Auth::user());
    }

    public function send(): void
    {
        $this->validate([
            'newMessage' => 'required|string|max:5000',
        ]);

        app(ConversationService::class)->sendMessage(
            $this->conversation,
            Auth::user(),
            $this->newMessage,
        );

        $this->newMessage = '';
    }

    public function render()
    {
        $messages = $this->conversation->messages()
            ->with('sender')
            ->get()
            ->reverse();

        $otherUser = $this->conversation->users
            ->firstWhere('id', '!=', Auth::id());

        return view('livewire.messages.show', [
            'messages' => $messages,
            'otherUser' => $otherUser,
        ]);
    }
}
