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
                        @if (in_array($application->status, ['hired', 'rejected']) && ! in_array($application->id, $userReviewIds))
                            <span class="text-xs text-lm-secondary">Pendiente de calificar</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Acciones --}}
            <div class="flex items-center gap-2 shrink-0 flex-wrap">
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
                @if (in_array($application->status, ['hired', 'rejected']) && ! in_array($application->id, $userReviewIds))
                    <button wire:click="openReviewModal('{{ $application->id }}')"
                            class="text-xs font-semibold px-3 py-1.5 rounded-lg border border-lm-outline-variant text-lm-on-surface-variant hover:bg-lm-secondary-container hover:text-lm-primary transition-colors">
                        <span class="material-symbols-outlined text-[14px] leading-none align-middle">star</span>
                        Calificar
                    </button>
                @endif

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

    {{-- Modal calificar candidato --}}
    @if ($showReviewModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4"
             wire:click.self="$set('showReviewModal', false)">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 flex flex-col gap-5"
                 wire:click.self.stop>
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-lm-on-surface">Calificar candidato</h2>
                    <button wire:click="$set('showReviewModal', false)"
                            class="p-1 rounded-lg text-lm-outline hover:bg-lm-surface-low transition-colors">
                        <span class="material-symbols-outlined text-xl leading-none">close</span>
                    </button>
                </div>

                <form wire:submit="submitReview" class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="text-sm font-semibold text-lm-on-surface">Puntuación</label>
                        <div class="flex gap-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button" wire:click="$set('reviewRating', {{ $i }})"
                                        class="text-2xl transition-colors hover:scale-110">
                                    <span class="{{ $i <= $reviewRating ? 'text-yellow-400' : 'text-lm-surface-highest' }}">★</span>
                                </button>
                            @endfor
                        </div>
                        @error('reviewRating') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="reviewComment" class="text-sm font-semibold text-lm-on-surface">
                            Comentario <span class="text-lm-outline font-normal">(opcional)</span>
                        </label>
                        <textarea id="reviewComment" wire:model="reviewComment" rows="3"
                                  class="w-full rounded-lg border border-lm-outline-variant px-3 py-2.5 text-sm text-lm-on-surface placeholder:text-lm-outline resize-none focus:outline-none focus:ring-2 focus:ring-lm-primary/20 focus:border-lm-primary"
                                  placeholder="Compartí tu experiencia con este candidato..."></textarea>
                        @error('reviewComment') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <button type="button" wire:click="$set('showReviewModal', false)"
                                class="text-sm font-semibold px-4 py-2 rounded-lg border border-lm-outline-variant text-lm-on-surface-variant hover:bg-lm-surface-low transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold text-white transition-opacity hover:opacity-80"
                                style="background-color:#003d9b;">
                            Enviar calificación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
