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

            @auth
                @if ($application)
                    @php $color = $application->statusColor(); @endphp
                    <div class="flex flex-col items-center md:items-end gap-2">
                        <span class="text-xs font-semibold px-3 py-1.5 rounded-full"
                              style="background-color:{{ $color['bg'] }}; color:{{ $color['text'] }};">
                            {{ $application->statusLabel() }}
                        </span>
                        @if ($application->match_score > 0)
                            <span class="text-xs text-lm-outline">Match {{ $application->match_score }}%</span>
                        @endif
                        @if ($application->conversation)
                            <a href="{{ route('conversations.show', $application->conversation) }}" wire:navigate
                               class="flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-lg border border-lm-primary text-lm-primary hover:bg-lm-secondary-container transition-colors">
                                <span class="material-symbols-outlined text-[14px] leading-none">chat</span>
                                Ir al chat
                            </a>
                        @endif
                    </div>
                @elseif (auth()->user()->role === 'candidate')
                    <button wire:click="openApplyModal"
                            class="flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold text-white transition-opacity hover:opacity-80"
                            style="background-color:#003d9b;">
                        <span class="material-symbols-outlined text-[18px] leading-none">send</span>
                        Postularme
                    </button>
                @else
                    <span class="flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold text-white opacity-50 cursor-not-allowed"
                          style="background-color:#003d9b;">
                        <span class="material-symbols-outlined text-[18px] leading-none">send</span>
                        Postularme
                    </span>
                    <span class="text-[11px] text-lm-outline text-center md:text-right">Solo candidatos</span>
                @endif
            @else
                <a href="{{ route('login') }}"
                   class="flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold text-white transition-opacity hover:opacity-80"
                   style="background-color:#003d9b;">
                    <span class="material-symbols-outlined text-[18px] leading-none">send</span>
                    Iniciar sesión para postularme
                </a>
            @endauth
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

    {{-- Modal de postulación --}}
    @if ($showApplyModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4"
             wire:click.self="$set('showApplyModal', false)">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6 flex flex-col gap-5"
                 wire:click.self.stop>
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-lm-on-surface">Postularte a {{ $jobPost->title }}</h2>
                    <button wire:click="$set('showApplyModal', false)"
                            class="p-1 rounded-lg text-lm-outline hover:bg-lm-surface-low transition-colors">
                        <span class="material-symbols-outlined text-xl leading-none">close</span>
                    </button>
                </div>

                <form wire:submit="submitApplication" class="flex flex-col gap-4">
                    <div class="flex flex-col gap-1.5">
                        <label for="coverLetter" class="text-sm font-semibold text-lm-on-surface">
                            Carta de presentación <span class="text-lm-outline font-normal">(opcional)</span>
                        </label>
                        <textarea id="coverLetter" wire:model="coverLetter" rows="5"
                                  class="w-full rounded-lg border border-lm-outline-variant px-3 py-2.5 text-sm text-lm-on-surface placeholder:text-lm-outline resize-none focus:outline-none focus:ring-2 focus:ring-lm-primary/20 focus:border-lm-primary"
                                  placeholder="Contale al empleador por qué sos el candidato ideal..."></textarea>
                        @error('coverLetter') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <button type="button" wire:click="$set('showApplyModal', false)"
                                class="text-sm font-semibold px-4 py-2 rounded-lg border border-lm-outline-variant text-lm-on-surface-variant hover:bg-lm-surface-low transition-colors">
                            Cancelar
                        </button>
                        <button type="submit"
                                class="flex items-center gap-2 px-5 py-2.5 rounded-lg text-sm font-semibold text-white transition-opacity hover:opacity-80"
                                style="background-color:#003d9b;">
                            <span class="material-symbols-outlined text-[18px] leading-none">send</span>
                            Enviar postulación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
