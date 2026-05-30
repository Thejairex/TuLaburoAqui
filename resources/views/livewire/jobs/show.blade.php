<div class="max-w-4xl mx-auto px-4 md:px-8 py-8 flex flex-col gap-6">

    {{-- Volver --}}
    <a href="{{ route('jobs.search') }}" wire:navigate
       class="flex items-center gap-1 text-sm font-semibold text-lm-primary w-fit hover:underline">
        <span class="material-symbols-outlined text-base leading-none">arrow_back</span>
        Volver al buscador
    </a>

    {{-- Encabezado --}}
    <div class="bg-white border border-lm-outline-variant rounded-xl p-6 flex flex-col md:flex-row gap-5 items-start">
        <div class="w-16 h-16 rounded-xl border border-lm-surface-highest bg-lm-surface-low flex items-center justify-center shrink-0 overflow-hidden">
            @if ($jobPost->company?->logoUrl())
                <img src="{{ $jobPost->company->logoUrl() }}" alt="" class="w-full h-full object-cover">
            @else
                <span class="material-symbols-outlined text-3xl leading-none text-lm-secondary">business</span>
            @endif
        </div>

        <div class="flex-1 min-w-0">
            <h1 class="text-2xl font-bold text-lm-on-surface">{{ $jobPost->title }}</h1>
            <div class="flex flex-wrap items-center gap-2 text-sm text-lm-on-surface-variant mt-1.5">
                @if ($jobPost->company)
                    <a href="{{ route('company.show', $jobPost->company) }}" wire:navigate
                       class="font-semibold text-lm-on-surface hover:text-lm-primary transition-colors">
                        {{ $jobPost->company->display_name ?? $jobPost->company->legal_name }}
                    </a>
                @endif
                @if ($jobPost->city)
                    <span class="w-1 h-1 rounded-full bg-lm-outline-variant"></span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px] leading-none">location_on</span>
                        {{ $jobPost->city }}{{ $jobPost->province ? ', ' . $jobPost->province : '' }}
                    </span>
                @endif
                @if ($jobPost->published_at)
                    <span class="w-1 h-1 rounded-full bg-lm-outline-variant"></span>
                    <span class="text-lm-outline">{{ $jobPost->published_at->diffForHumans() }}</span>
                @endif
            </div>

            {{-- Tags --}}
            <div class="flex flex-wrap gap-2 mt-3">
                @if ($jobPost->work_modality)
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-lm-secondary-container text-lm-primary">
                        {{ ['remote'=>'Remoto','on-site'=>'Presencial','hybrid'=>'Híbrido'][$jobPost->work_modality] ?? $jobPost->work_modality }}
                    </span>
                @endif
                @if ($jobPost->contract_type)
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-lm-surface-highest text-lm-secondary">
                        {{ ['full-time'=>'Tiempo completo','part-time'=>'Medio tiempo','contract'=>'Contrato','internship'=>'Pasantía','freelance'=>'Freelance'][$jobPost->contract_type] ?? $jobPost->contract_type }}
                    </span>
                @endif
                @if ($jobPost->seniority)
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-lm-surface-highest text-lm-secondary">
                        {{ ['junior'=>'Junior','mid'=>'Semi Senior','senior'=>'Senior','lead'=>'Lead'][$jobPost->seniority] ?? $jobPost->seniority }}
                    </span>
                @endif
                @if ($jobPost->vacancies > 1)
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-lm-surface-highest text-lm-secondary">
                        {{ $jobPost->vacancies }} vacantes
                    </span>
                @endif
            </div>
        </div>

        {{-- Salario + postular --}}
        <div class="flex flex-col items-stretch md:items-end gap-3 w-full md:w-auto shrink-0">
            @if ($jobPost->salary_visible && $jobPost->salary_min)
                <div class="md:text-right">
                    <span class="block text-xl font-bold text-lm-primary">
                        ${{ number_format($jobPost->salary_min, 0, ',', '.') }}@if($jobPost->salary_max) - ${{ number_format($jobPost->salary_max, 0, ',', '.') }}@endif
                    </span>
                    <span class="text-xs text-lm-outline">Salario estimado</span>
                </div>
            @endif
            <span class="flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold text-white opacity-50 cursor-not-allowed"
                  style="background-color:#003d9b;">
                <span class="material-symbols-outlined text-[18px] leading-none">send</span>
                Postularme
            </span>
            <span class="text-[11px] text-lm-outline text-center md:text-right">Postulación disponible pronto</span>
        </div>
    </div>

    {{-- Descripción --}}
    <div class="bg-white border border-lm-outline-variant rounded-xl p-6">
        <h2 class="text-base font-bold text-lm-on-surface mb-3">Descripción del puesto</h2>
        <div class="text-sm leading-relaxed text-lm-on-surface-variant whitespace-pre-line">{{ $jobPost->description }}</div>
    </div>

    {{-- Habilidades --}}
    @if ($jobPost->skills->isNotEmpty())
        <div class="bg-white border border-lm-outline-variant rounded-xl p-6">
            <h2 class="text-base font-bold text-lm-on-surface mb-3">Habilidades requeridas</h2>
            <div class="flex flex-wrap gap-2">
                @foreach ($jobPost->skills as $skill)
                    <span @class([
                        'text-xs font-semibold px-3 py-1.5 rounded-full',
                        'bg-lm-secondary-container text-lm-primary' => $skill->pivot->required,
                        'bg-lm-surface-highest text-lm-secondary' => ! $skill->pivot->required,
                    ])>
                        {{ $skill->name }}@if($skill->pivot->required) · excluyente @endif
                    </span>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Empresa --}}
    @if ($jobPost->company)
        <div class="bg-white border border-lm-outline-variant rounded-xl p-6 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-12 h-12 rounded-lg border border-lm-surface-highest bg-lm-surface-low flex items-center justify-center shrink-0 overflow-hidden">
                    @if ($jobPost->company->logoUrl())
                        <img src="{{ $jobPost->company->logoUrl() }}" alt="" class="w-full h-full object-cover">
                    @else
                        <span class="material-symbols-outlined text-xl leading-none text-lm-secondary">business</span>
                    @endif
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-lm-on-surface truncate">{{ $jobPost->company->display_name ?? $jobPost->company->legal_name }}</p>
                    @if ($jobPost->company->industry)
                        <p class="text-xs text-lm-outline">{{ $jobPost->company->industry }}</p>
                    @endif
                </div>
            </div>
            <a href="{{ route('company.show', $jobPost->company) }}" wire:navigate
               class="text-xs font-semibold px-4 py-2 rounded-lg border border-lm-primary text-lm-primary hover:bg-lm-secondary-container transition-colors whitespace-nowrap shrink-0">
                Ver empresa
            </a>
        </div>
    @endif
</div>
