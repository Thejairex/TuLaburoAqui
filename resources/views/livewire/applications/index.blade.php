<div class="max-w-4xl mx-auto px-4 md:px-8 py-8 flex flex-col gap-6">

    <div>
        <h1 class="text-2xl font-bold text-lm-on-surface">Mis postulaciones</h1>
        <p class="text-sm mt-0.5 text-lm-outline">Seguí el estado de cada oferta a la que te postulaste.</p>
    </div>

    @forelse ($applications as $application)
        @php $color = $application->statusColor(); @endphp
        <div class="bg-white rounded-xl border border-lm-outline-variant px-6 py-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-start gap-4 min-w-0 flex-1">
                {{-- Logo empresa --}}
                <div class="w-12 h-12 rounded-xl border border-lm-surface-highest bg-lm-surface-low flex items-center justify-center shrink-0 overflow-hidden">
                    @if ($application->jobPost?->company?->logoUrl())
                        <img src="{{ $application->jobPost->company->logoUrl() }}" alt="" class="w-full h-full object-cover">
                    @else
                        <span class="material-symbols-outlined text-xl leading-none text-lm-secondary">business</span>
                    @endif
                </div>

                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <a href="{{ route('jobs.show', $application->jobPost) }}" wire:navigate
                           class="text-base font-bold text-lm-on-surface hover:text-lm-primary transition-colors truncate">
                            {{ $application->jobPost->title }}
                        </a>
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full shrink-0"
                              style="background-color:{{ $color['bg'] }}; color:{{ $color['text'] }};">
                            {{ $application->statusLabel() }}
                        </span>
                    </div>
                    <p class="text-xs text-lm-outline mt-0.5">
                        {{ $application->jobPost->company->display_name ?? $application->jobPost->company->legal_name }}
                        @if ($application->jobPost->city)
                            · {{ $application->jobPost->city }}
                        @endif
                        @if ($application->applied_at)
                            · {{ $application->applied_at->diffForHumans() }}
                        @endif
                    </p>
                    @if ($application->match_score > 0)
                        <span class="text-xs font-semibold text-lm-primary mt-1 inline-block">
                            Match {{ $application->match_score }}%
                        </span>
                    @endif
                </div>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                @if ($application->conversation)
                    <a href="{{ route('conversations.show', $application->conversation) }}" wire:navigate
                       class="flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg border border-lm-primary text-lm-primary hover:bg-lm-secondary-container transition-colors">
                        <span class="material-symbols-outlined text-[14px] leading-none">chat</span>
                        Chat
                    </a>
                @endif
                @if ($application->status !== 'withdrawn')
                    <button wire:click="withdraw('{{ $application->id }}')"
                            wire:confirm="¿Retirar esta postulación?"
                            class="text-xs font-semibold px-3 py-1.5 rounded-lg border border-lm-outline-variant text-lm-on-surface-variant hover:bg-red-50 hover:text-red-600 transition-colors">
                        Retirar
                    </button>
                @endif
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl border border-lm-outline-variant px-6 py-12 flex flex-col items-center gap-3 text-center">
            <div class="w-14 h-14 rounded-full bg-lm-surface-highest flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl leading-none text-lm-secondary">work_off</span>
            </div>
            <p class="text-sm font-semibold text-lm-on-surface">Todavía no te postulaste a ninguna oferta</p>
            <p class="text-xs text-lm-outline max-w-sm">Explorá ofertas y postulate para empezar a seguir tus postulaciones.</p>
            <a href="{{ route('jobs.search') }}" wire:navigate
               class="mt-1 flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-white transition-opacity hover:opacity-80"
               style="background-color:#003d9b;">
                <span class="material-symbols-outlined text-[18px] leading-none">search</span>
                Buscar ofertas
            </a>
        </div>
    @endforelse

</div>
