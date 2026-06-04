<div class="max-w-5xl mx-auto px-4 md:px-8 py-8 flex flex-col gap-6">

    {{-- Encabezado --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-lm-on-surface">Mis ofertas</h1>
            <p class="text-sm mt-0.5 text-lm-outline">Gestioná tus búsquedas laborales: publicá, pausá o cerrá ofertas.</p>
        </div>
        <a href="{{ route('company.jobs.create') }}" wire:navigate
           class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-white shrink-0 transition-opacity hover:opacity-80"
           style="background-color:#003d9b;">
            <span class="material-symbols-outlined text-[18px] leading-none">add</span>
            Publicar oferta
        </a>
    </div>

    {{-- Listado --}}
    @forelse ($jobs as $job)
        @php $color = $job->statusColor(); @endphp
        <div class="bg-white rounded-xl border border-lm-outline-variant px-6 py-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex flex-col gap-1.5 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <h2 class="text-base font-bold text-lm-on-surface truncate">{{ $job->title }}</h2>
                    <span class="text-[11px] font-bold px-2 py-0.5 rounded-full"
                          style="background-color:{{ $color['bg'] }}; color:{{ $color['text'] }};">
                        {{ $job->statusLabel() }}
                    </span>
                </div>
                <p class="text-xs text-lm-outline flex items-center gap-2 flex-wrap">
                    @if ($job->work_modality)
                        <span class="capitalize">{{ $job->work_modality }}</span>
                        <span>·</span>
                    @endif
                    @if ($job->city)
                        <span>{{ $job->city }}{{ $job->province ? ', ' . $job->province : '' }}</span>
                        <span>·</span>
                    @endif
                    <span>{{ $job->vacancies }} {{ $job->vacancies === 1 ? 'vacante' : 'vacantes' }}</span>
                    <span>·</span>
                    <span>{{ $job->skills_count }} {{ $job->skills_count === 1 ? 'skill' : 'skills' }}</span>
                    <span>·</span>
                    <span>{{ $job->applications_count }} {{ $job->applications_count === 1 ? 'candidato' : 'candidatos' }}</span>
                </p>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                {{-- Cambios de estado contextuales --}}
                @if ($job->status === 'draft' || $job->status === 'paused')
                    <button wire:click="changeStatus('{{ $job->id }}', 'published')"
                            class="text-xs font-semibold px-3 py-1.5 rounded-lg text-white transition-opacity hover:opacity-80"
                            style="background-color:#003d9b;">
                        Publicar
                    </button>
                @endif

                @if ($job->status === 'published')
                    <button wire:click="changeStatus('{{ $job->id }}', 'paused')"
                            class="text-xs font-semibold px-3 py-1.5 rounded-lg border border-lm-outline-variant text-lm-on-surface-variant hover:bg-lm-surface-low transition-colors">
                        Pausar
                    </button>
                @endif

                @if (in_array($job->status, ['draft', 'published', 'paused'], true))
                    <button wire:click="changeStatus('{{ $job->id }}', 'closed')"
                            wire:confirm="¿Cerrar esta oferta? Dejará de estar visible."
                            class="text-xs font-semibold px-3 py-1.5 rounded-lg border border-lm-outline-variant text-lm-on-surface-variant hover:bg-lm-surface-low transition-colors">
                        Cerrar
                    </button>
                @endif

                <a href="{{ route('company.jobs.edit', $job) }}" wire:navigate
                   class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-lm-secondary-container text-lm-primary hover:opacity-80 transition-opacity">
                    Editar
                </a>

                <a href="{{ route('company.jobs.applicants', $job) }}" wire:navigate
                   class="text-xs font-semibold px-3 py-1.5 rounded-lg border border-lm-primary text-lm-primary hover:bg-lm-secondary-container transition-colors">
                    Candidatos
                </a>

                <button wire:click="delete('{{ $job->id }}')"
                        wire:confirm="¿Eliminar esta oferta definitivamente?"
                        class="p-1.5 rounded-lg text-lm-outline hover:text-red-600 hover:bg-red-50 transition-colors"
                        title="Eliminar">
                    <span class="material-symbols-outlined text-lg leading-none">delete</span>
                </button>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl border border-lm-outline-variant px-6 py-12 flex flex-col items-center gap-3 text-center">
            <div class="w-14 h-14 rounded-full bg-lm-surface-highest flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl leading-none text-lm-secondary">work_off</span>
            </div>
            <p class="text-sm font-semibold text-lm-on-surface">Todavía no publicaste ninguna oferta</p>
            <p class="text-xs text-lm-outline max-w-sm">Creá tu primera búsqueda laboral para empezar a recibir candidatos.</p>
            <a href="{{ route('company.jobs.create') }}" wire:navigate
               class="mt-1 flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-white transition-opacity hover:opacity-80"
               style="background-color:#003d9b;">
                <span class="material-symbols-outlined text-[18px] leading-none">add</span>
                Publicar oferta
            </a>
        </div>
    @endforelse

</div>
