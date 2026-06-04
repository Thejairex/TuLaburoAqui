<div class="max-w-4xl mx-auto px-4 md:px-8 py-8 flex flex-col gap-6">

    <div>
        <h1 class="text-2xl font-bold text-lm-on-surface">Mensajes</h1>
        <p class="text-sm mt-0.5 text-lm-outline">Tus conversaciones con empresas y candidatos.</p>
    </div>

    @forelse ($conversations as $item)
        @php
            $conv = $item->conversation;
            $job = $conv->jobApplication?->jobPost;
            $company = $job?->company;
        @endphp
        <a href="{{ route('conversations.show', $conv) }}" wire:navigate
           class="bg-white rounded-xl border border-lm-outline-variant px-6 py-4 flex items-start gap-4 hover:shadow-sm transition-shadow">
            {{-- Avatar del otro usuario --}}
            <div class="w-11 h-11 rounded-full bg-lm-secondary-container flex items-center justify-center shrink-0 overflow-hidden">
                @if ($item->otherUser?->avatarUrl())
                    <img src="{{ $item->otherUser->avatarUrl() }}" alt="" class="w-full h-full object-cover">
                @else
                    <span class="text-sm font-bold text-lm-primary">{{ $item->otherUser?->initials() ?? '?' }}</span>
                @endif
            </div>

            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2 min-w-0">
                        <span class="text-sm font-bold text-lm-on-surface truncate">
                            {{ $item->otherUser?->name ?? 'Usuario' }}
                        </span>
                        @if ($item->unread > 0)
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-full bg-lm-primary text-white">{{ $item->unread }}</span>
                        @endif
                    </div>
                    @if ($item->lastMessage)
                        <span class="text-xs text-lm-outline shrink-0">{{ $item->lastMessage->created_at->diffForHumans() }}</span>
                    @endif
                </div>
                <p class="text-xs text-lm-on-surface-variant mt-0.5 truncate">
                    {{ $conv->subject }}
                </p>
                @if ($item->lastMessage)
                    <p class="text-xs text-lm-outline mt-1 truncate">
                        {{ $item->lastMessage->sender->name }}: {{ $item->lastMessage->body }}
                    </p>
                @else
                    <p class="text-xs text-lm-outline mt-1 italic">Sin mensajes todavía</p>
                @endif
            </div>
        </a>
    @empty
        <div class="bg-white rounded-xl border border-lm-outline-variant px-6 py-12 flex flex-col items-center gap-3 text-center">
            <div class="w-14 h-14 rounded-full bg-lm-surface-highest flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl leading-none text-lm-secondary">chat</span>
            </div>
            <p class="text-sm font-semibold text-lm-on-surface">No tenés mensajes todavía</p>
            <p class="text-xs text-lm-outline max-w-sm">Las conversaciones con empresas o candidatos aparecerán acá.</p>
        </div>
    @endforelse

</div>
