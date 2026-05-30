<div class="max-w-6xl mx-auto px-4 md:px-8 py-8 flex flex-col md:flex-row gap-6">

    {{-- ─── Filtros ─────────────────────────────────────────────── --}}
    <aside class="w-full md:w-1/4 shrink-0">
        <div class="bg-white border border-lm-outline-variant rounded-xl p-5 md:sticky md:top-20 flex flex-col gap-5">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-bold text-lm-on-surface">Filtros</h2>
                <button type="button" wire:click="clearFilters"
                        class="text-xs font-semibold text-lm-primary hover:underline">Limpiar</button>
            </div>

            {{-- Ubicación --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-semibold text-lm-on-surface-variant">Ubicación</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-base leading-none text-lm-outline">location_on</span>
                    <input type="text" wire:model.live.debounce.400ms="city" placeholder="Ciudad o provincia"
                           class="w-full pl-9 pr-3 py-2 bg-white border border-lm-outline-variant rounded-lg text-sm text-lm-on-surface focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                </div>
            </div>

            {{-- Salario mínimo --}}
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-semibold text-lm-on-surface-variant">Salario mínimo</label>
                <select wire:model.live="salaryMin"
                        class="w-full px-3 py-2 bg-white border border-lm-outline-variant rounded-lg text-sm text-lm-on-surface focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                    <option value="">Cualquiera</option>
                    <option value="1000">Desde $1.000</option>
                    <option value="1500">Desde $1.500</option>
                    <option value="2000">Desde $2.000</option>
                    <option value="3000">Desde $3.000</option>
                </select>
            </div>

            {{-- Tipo de contrato --}}
            <div class="flex flex-col gap-2">
                <label class="text-xs font-semibold text-lm-on-surface-variant">Tipo de contrato</label>
                @foreach (['full-time' => 'Tiempo completo', 'part-time' => 'Medio tiempo', 'contract' => 'Contrato', 'internship' => 'Pasantía', 'freelance' => 'Freelance'] as $value => $label)
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" wire:model.live="contractTypes" value="{{ $value }}"
                               class="w-4 h-4 rounded border-lm-outline-variant text-lm-primary focus:ring-lm-primary">
                        <span class="text-sm text-lm-on-surface group-hover:text-lm-primary transition-colors">{{ $label }}</span>
                    </label>
                @endforeach
            </div>

            {{-- Modalidad --}}
            <div class="flex flex-col gap-2">
                <label class="text-xs font-semibold text-lm-on-surface-variant">Modalidad</label>
                @foreach (['remote' => 'Remoto', 'on-site' => 'Presencial', 'hybrid' => 'Híbrido'] as $value => $label)
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" wire:model.live="modalities" value="{{ $value }}"
                               class="w-4 h-4 rounded border-lm-outline-variant text-lm-primary focus:ring-lm-primary">
                        <span class="text-sm text-lm-on-surface group-hover:text-lm-primary transition-colors">{{ $label }}</span>
                    </label>
                @endforeach
            </div>

            {{-- Seniority --}}
            <div class="flex flex-col gap-2">
                <label class="text-xs font-semibold text-lm-on-surface-variant">Nivel</label>
                @foreach (['junior' => 'Junior', 'mid' => 'Semi Senior', 'senior' => 'Senior', 'lead' => 'Lead'] as $value => $label)
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" wire:model.live="seniorities" value="{{ $value }}"
                               class="w-4 h-4 rounded border-lm-outline-variant text-lm-primary focus:ring-lm-primary">
                        <span class="text-sm text-lm-on-surface group-hover:text-lm-primary transition-colors">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>
    </aside>

    {{-- ─── Resultados ──────────────────────────────────────────── --}}
    <section class="w-full md:w-3/4 flex flex-col gap-4">

        {{-- Barra de búsqueda + orden --}}
        <div class="bg-white border border-lm-outline-variant rounded-xl p-3 flex flex-col sm:flex-row gap-3 justify-between items-stretch sm:items-center">
            <div class="relative flex-1">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lm-outline leading-none">search</span>
                <input type="text" wire:model.live.debounce.400ms="keyword"
                       placeholder="Buscar por puesto, empresa o palabra clave"
                       class="w-full pl-10 pr-4 py-2 bg-white border border-lm-outline-variant rounded-lg text-sm text-lm-on-surface focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <label class="text-xs font-semibold text-lm-on-surface-variant whitespace-nowrap">Ordenar:</label>
                <select wire:model.live="sort"
                        class="px-3 py-2 bg-white border border-lm-outline-variant rounded-lg text-sm text-lm-on-surface focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent cursor-pointer">
                    <option value="recent">Más recientes</option>
                    <option value="salary">Mayor salario</option>
                </select>
            </div>
        </div>

        <p class="text-xs text-lm-outline px-1">
            {{ $jobs->total() }} {{ $jobs->total() === 1 ? 'oferta encontrada' : 'ofertas encontradas' }}
        </p>

        {{-- Listado --}}
        <div class="flex flex-col gap-3">
            @forelse ($jobs as $job)
                <article class="bg-white border border-lm-outline-variant rounded-xl p-5 hover:shadow-sm hover:border-lm-outline transition-all group">
                    <div class="flex flex-col sm:flex-row gap-4">
                        {{-- Logo --}}
                        <div class="w-14 h-14 rounded-lg border border-lm-surface-highest bg-lm-surface-low flex items-center justify-center shrink-0 overflow-hidden">
                            @if ($job->company?->logoUrl())
                                <img src="{{ $job->company->logoUrl() }}" alt="" class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-2xl leading-none text-lm-secondary">business</span>
                            @endif
                        </div>

                        {{-- Detalle --}}
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('jobs.show', $job) }}" wire:navigate
                               class="text-base font-bold text-lm-on-surface group-hover:text-lm-primary transition-colors">
                                {{ $job->title }}
                            </a>
                            <div class="flex flex-wrap items-center gap-2 text-xs text-lm-on-surface-variant mt-1">
                                <span class="font-semibold text-lm-on-surface">{{ $job->company?->display_name ?? $job->company?->legal_name }}</span>
                                @if ($job->city)
                                    <span class="w-1 h-1 rounded-full bg-lm-outline-variant"></span>
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px] leading-none">location_on</span>
                                        {{ $job->city }}@if($job->work_modality) ({{ ['remote'=>'Remoto','on-site'=>'Presencial','hybrid'=>'Híbrido'][$job->work_modality] ?? $job->work_modality }})@endif
                                    </span>
                                @endif
                                @if ($job->published_at)
                                    <span class="w-1 h-1 rounded-full bg-lm-outline-variant"></span>
                                    <span class="text-lm-outline">{{ $job->published_at->diffForHumans() }}</span>
                                @endif
                            </div>

                            {{-- Tags --}}
                            <div class="flex flex-wrap gap-2 mt-3">
                                @if ($job->contract_type)
                                    <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full bg-lm-surface-highest text-lm-secondary">
                                        {{ ['full-time'=>'Tiempo completo','part-time'=>'Medio tiempo','contract'=>'Contrato','internship'=>'Pasantía','freelance'=>'Freelance'][$job->contract_type] ?? $job->contract_type }}
                                    </span>
                                @endif
                                @if ($job->seniority)
                                    <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full bg-lm-secondary-container text-lm-primary">
                                        {{ ['junior'=>'Junior','mid'=>'Semi Senior','senior'=>'Senior','lead'=>'Lead'][$job->seniority] ?? $job->seniority }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Salario + acción --}}
                        <div class="flex flex-row sm:flex-col justify-between items-start sm:items-end sm:min-w-[130px] gap-2">
                            <div class="sm:text-right">
                                @if ($job->salary_visible && $job->salary_min)
                                    <span class="block text-base font-bold text-lm-primary">
                                        ${{ number_format($job->salary_min, 0, ',', '.') }}@if($job->salary_max) - ${{ number_format($job->salary_max, 0, ',', '.') }}@endif
                                    </span>
                                @else
                                    <span class="block text-xs text-lm-outline">Salario a convenir</span>
                                @endif
                            </div>
                            <a href="{{ route('jobs.show', $job) }}" wire:navigate
                               class="text-xs font-semibold px-4 py-2 rounded-lg border border-lm-primary text-lm-primary hover:bg-lm-secondary-container transition-colors whitespace-nowrap">
                                Ver detalle
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="bg-white border border-lm-outline-variant rounded-xl px-6 py-12 flex flex-col items-center gap-3 text-center">
                    <div class="w-14 h-14 rounded-full bg-lm-surface-highest flex items-center justify-center">
                        <span class="material-symbols-outlined text-3xl leading-none text-lm-secondary">search_off</span>
                    </div>
                    <p class="text-sm font-semibold text-lm-on-surface">No encontramos ofertas con esos filtros</p>
                    <p class="text-xs text-lm-outline max-w-sm">Probá ajustar la búsqueda o limpiar los filtros.</p>
                    <button type="button" wire:click="clearFilters"
                            class="mt-1 text-xs font-semibold px-4 py-2 rounded-lg border border-lm-primary text-lm-primary hover:bg-lm-secondary-container transition-colors">
                        Limpiar filtros
                    </button>
                </div>
            @endforelse
        </div>

        {{-- Paginación --}}
        @if ($jobs->hasPages())
            <div class="mt-2">
                {{ $jobs->links() }}
            </div>
        @endif
    </section>
</div>
