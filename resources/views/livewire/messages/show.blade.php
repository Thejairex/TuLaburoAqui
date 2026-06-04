<div class="max-w-4xl mx-auto px-4 md:px-8 py-8 flex flex-col gap-4 h-[calc(100vh-10rem)]">

    {{-- Encabezado --}}
    <div class="flex items-center gap-3 bg-white rounded-xl border border-lm-outline-variant px-6 py-4 shrink-0">
        <a href="{{ route('conversations.index') }}" wire:navigate
           class="flex items-center justify-center w-8 h-8 rounded-lg text-lm-outline hover:bg-lm-surface-low transition-colors">
            <span class="material-symbols-outlined text-lg leading-none">arrow_back</span>
        </a>

        <div class="w-10 h-10 rounded-full bg-lm-secondary-container flex items-center justify-center shrink-0 overflow-hidden">
            @if ($otherUser?->avatarUrl())
                <img src="{{ $otherUser->avatarUrl() }}" alt="" class="w-full h-full object-cover">
            @else
                <span class="text-sm font-bold text-lm-primary">{{ $otherUser?->initials() ?? '?' }}</span>
            @endif
        </div>

        <div class="min-w-0 flex-1">
            <p class="text-sm font-bold text-lm-on-surface truncate">{{ $otherUser?->name ?? 'Usuario' }}</p>
            <p class="text-xs text-lm-outline truncate">{{ $conversation->subject }}</p>
        </div>
    </div>

    {{-- Mensajes --}}
    <div class="flex-1 bg-white rounded-xl border border-lm-outline-variant p-6 overflow-y-auto flex flex-col gap-3"
         wire:poll.5000ms>
        @forelse ($messages as $message)
            <div @class([
                'flex',
                'justify-end' => $message->sender_user_id === auth()->id(),
                'justify-start' => $message->sender_user_id !== auth()->id(),
            ])>
                <div @class([
                    'max-w-[75%] rounded-xl px-4 py-2.5 text-sm',
                    'bg-lm-primary text-white rounded-br-md' => $message->sender_user_id === auth()->id(),
                    'bg-lm-surface-low text-lm-on-surface rounded-bl-md' => $message->sender_user_id !== auth()->id(),
                ])>
                    <p class="leading-relaxed">{{ $message->body }}</p>
                    <p @class([
                        'text-[10px] mt-1 text-right',
                        'text-white/70' => $message->sender_user_id === auth()->id(),
                        'text-lm-outline' => $message->sender_user_id !== auth()->id(),
                    ])>
                        {{ $message->created_at->format('H:i') }}
                        @if ($message->sender_user_id === auth()->id() && $message->read_at)
                            · Leído
                        @endif
                    </p>
                </div>
            </div>
        @empty
            <div class="flex-1 flex items-center justify-center">
                <div class="text-center">
                    <div class="w-12 h-12 rounded-full bg-lm-surface-highest flex items-center justify-center mx-auto">
                        <span class="material-symbols-outlined text-2xl leading-none text-lm-secondary">chat</span>
                    </div>
                    <p class="text-sm text-lm-outline mt-3">No hay mensajes todavía</p>
                    <p class="text-xs text-lm-outline mt-1">Enviá el primer mensaje para iniciar la conversación.</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Input --}}
    <div class="bg-white rounded-xl border border-lm-outline-variant px-4 py-3 shrink-0">
        <form wire:submit="send" class="flex items-center gap-3">
            <input type="text" wire:model="newMessage" placeholder="Escribí un mensaje..."
                   class="flex-1 border-none outline-none text-sm text-lm-on-surface placeholder:text-lm-outline bg-transparent">
            <button type="submit" @class([
                'flex items-center justify-center w-9 h-9 rounded-lg transition-colors',
                'bg-lm-primary text-white hover:opacity-80' => strlen($newMessage) > 0,
                'bg-lm-surface-highest text-lm-outline cursor-not-allowed' => strlen($newMessage) === 0,
            ])>
                <span class="material-symbols-outlined text-[18px] leading-none">send</span>
            </button>
        </form>
        @error('newMessage') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
    </div>

</div>
