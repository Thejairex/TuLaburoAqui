<div class="max-w-5xl mx-auto px-4 md:px-8 py-8 flex flex-col gap-6">

    {{-- Encabezado --}}
    <div class="flex flex-col gap-1">
        <a href="{{ route('company.jobs.index') }}" wire:navigate
           class="flex items-center gap-1 text-sm font-semibold text-lm-primary w-fit hover:underline">
            <span class="material-symbols-outlined text-base leading-none">arrow_back</span>
            Volver a mis ofertas
        </a>
        <h1 class="text-2xl font-bold text-lm-on-surface mt-1">Candidatos para {{ $jobPost->title }}</h1>
        <p class="text-sm text-lm-outline">{{ $applications->count() }} {{ $applications->count() === 1 ? 'postulación' : 'postulaciones' }}</p>
    </div>

    {{-- Lista --}}
    @forelse ($applications as $application)
        @php $appColor = $application->statusColor(); @endphp
        <div class="bg-white rounded-xl border border-lm-outline-variant px-6 py-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-start gap-4 min-w-0 flex-1">
                {{-- Avatar --}}
                <div class="w-12 h-12 rounded-full bg-lm-secondary-container flex items-center justify-center shrink-0 overflow-hidden">
                    @if ($application->user->avatarUrl())
                        <img src="{{ $application->user->avatarUrl() }}" alt="" class="w-full h-full object-cover">
                    @else
                        <span class="text-sm font-bold text-lm-primary">{{ $application->user->initials() }}</span>
                    @endif
                </div>

                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-base font-bold text-lm-on-surface">{{ $application->user->name }}</span>
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full shrink-0"
                              style="background-color:{{ $appColor['bg'] }}; color:{{ $appColor['text'] }};">
                            {{ $application->statusLabel() }}
                        </span>
                    </div>
                    @if ($application->user->workerProfile?->headline)
                        <p class="text-xs text-lm-on-surface-variant mt-0.5">{{ $application->user->workerProfile->headline }}</p>
                    @endif
                    <div class="flex items-center gap-3 mt-1.5 flex-wrap">
                        @if ($application->match_score > 0)
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-lm-secondary-container text-lm-primary">
                                Match {{ $application->match_score }}%
                            </span>
                        @endif
                        @if ($application->applied_at)
                            <span class="text-xs text-lm-outline">Postulado {{ $application->applied_at->diffForHumans() }}</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Acciones --}}
            <div class="flex items-center gap-2 shrink-0 flex-wrap">
                {{-- Cambiar estado --}}
                @if ($application->status === 'submitted')
                    <button wire:click="changeStatus('{{ $application->id }}', 'in_review')"
                            class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-lm-secondary-container text-lm-primary hover:opacity-80 transition-opacity">
                        Revisar
                    </button>
                @endif
                @if ($application->status === 'in_review')
                    <button wire:click="changeStatus('{{ $application->id }}', 'shortlisted')"
                            class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-green-50 text-green-700 hover:opacity-80 transition-opacity">
                        Preseleccionar
                    </button>
                    <button wire:click="changeStatus('{{ $application->id }}', 'rejected')"
                            class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:opacity-80 transition-opacity">
                        Rechazar
                    </button>
                @endif
                @if ($application->status === 'shortlisted')
                    <button wire:click="changeStatus('{{ $application->id }}', 'hired')"
                            wire:confirm="¿Confirmar contratación?"
                            class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:opacity-80 transition-opacity">
                        Contratar
                    </button>
                    <button wire:click="changeStatus('{{ $application->id }}', 'rejected')"
                            class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:opacity-80 transition-opacity">
                        Rechazar
                    </button>
                @endif
                @if ($application->status === 'rejected' || $application->status === 'hired')
                    <span class="text-xs text-lm-outline">Finalizado</span>
                @endif

                {{-- Chat --}}
                <button wire:click="startConversation('{{ $application->id }}')"
                        class="flex items-center gap-1 text-xs font-semibold px-3 py-1.5 rounded-lg border border-lm-primary text-lm-primary hover:bg-lm-secondary-container transition-colors">
                    <span class="material-symbols-outlined text-[14px] leading-none">chat</span>
                    {{ $application->conversation ? 'Ir al chat' : 'Iniciar chat' }}
                </button>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl border border-lm-outline-variant px-6 py-12 flex flex-col items-center gap-3 text-center">
            <div class="w-14 h-14 rounded-full bg-lm-surface-highest flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl leading-none text-lm-secondary">group_off</span>
            </div>
            <p class="text-sm font-semibold text-lm-on-surface">Todavía no hay candidatos para esta oferta</p>
            <p class="text-xs text-lm-outline max-w-sm">Cuando los candidatos se postulen, aparecerán acá.</p>
        </div>
    @endforelse

</div>
