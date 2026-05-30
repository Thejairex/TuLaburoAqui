<div class="max-w-5xl mx-auto px-4 md:px-8 py-8 flex flex-col gap-8">

    {{-- Hero / Bienvenida --}}
    <section class="bg-white rounded-xl border border-lm-outline-variant px-6 py-6 flex flex-col md:flex-row md:items-center justify-between gap-5">
        <div class="flex flex-col gap-2 max-w-xl">
            <p class="text-xs font-bold tracking-widest uppercase text-lm-primary">Empleador</p>
            <h1 class="text-2xl font-bold text-lm-on-surface">
                Hola, {{ $company?->display_name ?? $company?->legal_name ?? auth()->user()->name }} 👋
            </h1>
            <p class="text-sm text-lm-on-surface-variant">
                @if ($company)
                    Desde acá gestionás las ofertas laborales, revisás postulaciones y administrás el perfil de
                    <span class="font-semibold text-lm-on-surface">{{ $company->legal_name }}</span>.
                @else
                    Bienvenido a tu panel de empresa. Completá el perfil para empezar a publicar ofertas y encontrar candidatos.
                @endif
            </p>
        </div>

        <div class="flex flex-wrap gap-3 shrink-0">
            <a href="{{ route('company.edit') }}" wire:navigate
               class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold border border-lm-primary text-lm-primary hover:bg-lm-secondary-container transition-colors">
                <span class="material-symbols-outlined text-[18px] leading-none">business</span>
                Perfil de empresa
            </a>
            <a href="{{ route('company.jobs.create') }}" wire:navigate
               class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-white transition-opacity hover:opacity-80"
               style="background-color:#003d9b;">
                <span class="material-symbols-outlined text-[18px] leading-none">add</span>
                Publicar oferta
            </a>
        </div>
    </section>

    {{-- Métricas --}}
    <section class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $metrics = [
                ['label' => 'Ofertas Activas',  'value' => (string) $publishedCount, 'note' => 'Publicadas', 'icon' => 'work'],
                ['label' => 'Postulaciones',    'value' => '—', 'note' => 'Próximamente', 'icon' => 'description'],
                ['label' => 'Contactados',      'value' => '—', 'note' => 'Próximamente', 'icon' => 'mail'],
                ['label' => 'Entrevistas',      'value' => '—', 'note' => 'Próximamente', 'icon' => 'calendar_today'],
            ];
        @endphp

        @foreach ($metrics as $metric)
            <div class="bg-white rounded-xl border border-lm-outline-variant px-5 py-5 flex flex-col gap-2">
                <div class="flex items-center justify-between text-lm-secondary">
                    <span class="text-xs font-semibold">{{ $metric['label'] }}</span>
                    <span class="material-symbols-outlined text-xl leading-none">{{ $metric['icon'] }}</span>
                </div>
                <div class="text-3xl font-bold text-lm-primary">{{ $metric['value'] }}</div>
                <div class="text-xs font-semibold px-2 py-0.5 rounded-full w-fit bg-lm-surface-highest text-lm-secondary">
                    {{ $metric['note'] }}
                </div>
            </div>
        @endforeach
    </section>

    {{-- Cuerpo principal: checklist + accesos rápidos --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Columna principal: perfil + checklist --}}
        <div class="lg:col-span-2 flex flex-col gap-6">

            {{-- Resumen de perfil de empresa --}}
            <div class="bg-white rounded-xl border border-lm-outline-variant px-6 py-5 flex flex-col gap-4">
                <div class="flex items-start gap-4">
                    {{-- Logo --}}
                    <div class="w-14 h-14 rounded-xl flex items-center justify-center shrink-0 overflow-hidden bg-lm-secondary-container">
                        @if ($company?->logoUrl())
                            <img src="{{ $company->logoUrl() }}" alt="Logo" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined text-2xl leading-none text-lm-primary">business</span>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-base font-bold text-lm-on-surface truncate">
                            {{ $company?->display_name ?? $company?->legal_name ?? '—' }}
                        </p>
                        @if ($company?->industry)
                            <p class="text-sm mt-0.5 text-lm-on-surface-variant">{{ $company->industry }}</p>
                        @else
                            <p class="text-sm mt-0.5 text-lm-outline">Sin industria — completá tu perfil</p>
                        @endif
                        @if ($company?->city)
                            <p class="text-xs mt-1 flex items-center gap-1 text-lm-outline">
                                <span class="material-symbols-outlined text-sm leading-none">location_on</span>
                                {{ $company->city }}{{ $company->province ? ', ' . $company->province : '' }}
                            </p>
                        @endif
                    </div>

                    {{-- Completitud desktop --}}
                    <div class="hidden sm:flex flex-col items-end gap-1.5 shrink-0">
                        <span class="text-xs font-semibold text-lm-secondary">Perfil {{ $percentage }}% completo</span>
                        <div class="w-32 h-2 rounded-full overflow-hidden bg-lm-surface-highest">
                            <div class="h-2 rounded-full transition-all"
                                 style="width:{{ $percentage }}%; background-color:{{ $percentage >= 70 ? '#006d36' : '#003d9b' }};"></div>
                        </div>
                    </div>
                </div>

                {{-- Completitud mobile --}}
                <div class="flex flex-col gap-1 sm:hidden">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-lm-secondary">Perfil completo</span>
                        <span class="text-xs font-semibold text-lm-primary">{{ $percentage }}%</span>
                    </div>
                    <div class="w-full h-2 rounded-full overflow-hidden bg-lm-surface-highest">
                        <div class="h-2 rounded-full"
                             style="width:{{ $percentage }}%; background-color:{{ $percentage >= 70 ? '#006d36' : '#003d9b' }};"></div>
                    </div>
                </div>

                <a href="{{ route('company.edit') }}" wire:navigate
                   class="self-start text-xs font-semibold px-4 py-2 rounded-lg border border-lm-primary text-lm-primary hover:bg-lm-secondary-container transition-colors">
                    Editar perfil
                </a>
            </div>

            {{-- Checklist --}}
            @if (count($pending) > 0)
                <div class="bg-white rounded-xl border border-lm-outline-variant px-6 py-5 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-base font-bold text-lm-on-surface">Completá el perfil de empresa</h2>
                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-lm-secondary-container text-lm-primary">
                            {{ count($pending) }} {{ count($pending) === 1 ? 'paso pendiente' : 'pasos pendientes' }}
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        @foreach ($items as $item)
                            <div @class([
                                'flex items-center gap-3 px-4 py-3 rounded-lg border',
                                'border-green-200 bg-green-50' => $item['done'],
                                'border-lm-surface-highest bg-lm-surface-low' => ! $item['done'],
                            ])>
                                <div @class([
                                    'w-8 h-8 rounded-full flex items-center justify-center shrink-0',
                                    'bg-green-600' => $item['done'],
                                    'bg-lm-surface-highest' => ! $item['done'],
                                ])>
                                    @if ($item['done'])
                                        <span class="material-symbols-outlined text-sm leading-none text-white">check</span>
                                    @else
                                        <span class="material-symbols-outlined text-sm leading-none text-lm-secondary">{{ $item['icon'] }}</span>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <p @class([
                                        'text-sm font-semibold',
                                        'text-green-700' => $item['done'],
                                        'text-lm-on-surface' => ! $item['done'],
                                    ])>{{ $item['label'] }}</p>
                                    @if (! $item['done'])
                                        <p class="text-xs mt-0.5 text-lm-outline">{{ $item['description'] }}</p>
                                    @endif
                                </div>

                                @if (! $item['done'])
                                    <a href="{{ route('company.edit') }}#{{ $item['anchor'] }}" wire:navigate
                                       class="text-xs font-semibold px-3 py-1.5 rounded-lg shrink-0 text-white transition-opacity hover:opacity-80"
                                       style="background-color:#003d9b;">
                                        Completar
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="flex items-center gap-4 px-6 py-5 rounded-xl border border-green-200 bg-green-50">
                    <div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-xl text-white leading-none">verified</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-green-700">Perfil de empresa completo</p>
                        <p class="text-xs mt-0.5 text-lm-on-surface-variant">Tu empresa está visible y lista para publicar ofertas.</p>
                    </div>
                </div>
            @endif

            {{-- Ofertas recientes --}}
            <div class="bg-white rounded-xl border border-lm-outline-variant px-6 py-5 flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-bold text-lm-on-surface">Ofertas recientes</h2>
                    @if ($recentJobs->isNotEmpty())
                        <a href="{{ route('company.jobs.index') }}" wire:navigate
                           class="text-xs font-semibold text-lm-primary hover:underline">Ver todas</a>
                    @endif
                </div>

                @forelse ($recentJobs as $job)
                    @php $color = $job->statusColor(); @endphp
                    <a href="{{ route('company.jobs.edit', $job) }}" wire:navigate
                       class="flex items-center justify-between gap-3 p-3 rounded-lg border border-lm-surface-highest hover:bg-lm-surface-low transition-colors">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-lm-on-surface truncate">{{ $job->title }}</p>
                            <p class="text-xs text-lm-outline">{{ $job->vacancies }} {{ $job->vacancies === 1 ? 'vacante' : 'vacantes' }}</p>
                        </div>
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full shrink-0"
                              style="background-color:{{ $color['bg'] }}; color:{{ $color['text'] }};">
                            {{ $job->statusLabel() }}
                        </span>
                    </a>
                @empty
                    <div class="flex flex-col items-center justify-center py-8 gap-3">
                        <div class="w-12 h-12 rounded-full bg-lm-surface-highest flex items-center justify-center">
                            <span class="material-symbols-outlined text-2xl leading-none text-lm-secondary">work_off</span>
                        </div>
                        <p class="text-sm text-lm-outline text-center">Todavía no publicaste ninguna oferta.</p>
                        <a href="{{ route('company.jobs.create') }}" wire:navigate
                           class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-white transition-opacity hover:opacity-80"
                           style="background-color:#003d9b;">
                            <span class="material-symbols-outlined text-[18px] leading-none">add</span>
                            Publicar oferta
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Columna lateral: accesos rápidos --}}
        <div class="flex flex-col gap-4">

            <a href="{{ route('company.edit') }}" wire:navigate
               class="bg-white rounded-xl border border-lm-outline-variant px-5 py-5 flex flex-col gap-3 hover:shadow-sm transition-shadow">
                <div class="w-10 h-10 rounded-lg bg-lm-secondary-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl leading-none text-lm-primary">business</span>
                </div>
                <div>
                    <p class="text-sm font-bold text-lm-on-surface">Perfil de empresa</p>
                    <p class="text-xs mt-0.5 text-lm-outline">Logo, industria, descripción y contacto</p>
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-lm-secondary">Completitud</span>
                        <span class="text-xs font-semibold text-lm-primary">{{ $percentage }}%</span>
                    </div>
                    <div class="w-full h-1.5 rounded-full overflow-hidden bg-lm-surface-highest">
                        <div class="h-1.5 rounded-full" style="width:{{ $percentage }}%; background-color:#003d9b;"></div>
                    </div>
                </div>
            </a>

            <a href="{{ route('company.edit') }}#identidad" wire:navigate
               class="bg-white rounded-xl border border-lm-outline-variant px-5 py-5 flex flex-col gap-3 hover:shadow-sm transition-shadow">
                <div class="w-10 h-10 rounded-lg bg-lm-secondary-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl leading-none text-lm-primary">image</span>
                </div>
                <div>
                    <p class="text-sm font-bold text-lm-on-surface">Logo de empresa</p>
                    <p class="text-xs mt-0.5 text-lm-outline">
                        {{ $company?->logoUrl() ? 'Reemplazá el logo de tu empresa' : 'Subí el logo de tu empresa' }}
                    </p>
                </div>
                @if ($company?->logoUrl())
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full w-fit bg-green-50 text-green-700 flex items-center gap-1">
                        <span class="material-symbols-outlined text-xs leading-none">check_circle</span> Logo cargado
                    </span>
                @else
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full w-fit bg-lm-secondary-container text-lm-primary">
                        Subir ahora
                    </span>
                @endif
            </a>

            <a href="{{ route('company.jobs.index') }}" wire:navigate
               class="bg-white rounded-xl border border-lm-outline-variant px-5 py-5 flex flex-col gap-3 hover:shadow-sm transition-shadow">
                <div class="w-10 h-10 rounded-lg bg-lm-secondary-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl leading-none text-lm-primary">post_add</span>
                </div>
                <div>
                    <p class="text-sm font-bold text-lm-on-surface">Mis ofertas</p>
                    <p class="text-xs mt-0.5 text-lm-outline">Publicá y gestioná tus búsquedas laborales</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full w-fit bg-lm-secondary-container text-lm-primary">
                    Gestionar
                </span>
            </a>

            <div class="bg-white rounded-xl border border-lm-outline-variant px-5 py-5 flex flex-col gap-3 opacity-50">
                <div class="w-10 h-10 rounded-lg bg-lm-surface-highest flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl leading-none text-lm-secondary">group</span>
                </div>
                <div>
                    <p class="text-sm font-bold text-lm-on-surface">Candidatos</p>
                    <p class="text-xs mt-0.5 text-lm-outline">Revisá postulaciones a tus ofertas</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full w-fit bg-lm-surface-highest text-lm-secondary">Próximamente</span>
            </div>

            <div class="bg-white rounded-xl border border-lm-outline-variant px-5 py-5 flex flex-col gap-3 opacity-50">
                <div class="w-10 h-10 rounded-lg bg-lm-surface-highest flex items-center justify-center">
                    <span class="material-symbols-outlined text-xl leading-none text-lm-secondary">chat</span>
                </div>
                <div>
                    <p class="text-sm font-bold text-lm-on-surface">Mensajes</p>
                    <p class="text-xs mt-0.5 text-lm-outline">Conversaciones con candidatos</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full w-fit bg-lm-surface-highest text-lm-secondary">Próximamente</span>
            </div>
        </div>
    </div>

</div>
