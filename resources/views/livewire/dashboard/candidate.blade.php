<div class="flex flex-col gap-6 max-w-6xl mx-auto px-4 md:px-8 py-8">

    {{-- Bienvenida --}}
    <div class="bg-white rounded-xl border border-lm-outline-variant px-6 py-5">
        <p class="text-xs font-bold tracking-widest uppercase text-lm-primary mb-1">Candidato</p>
        <h1 class="text-2xl font-bold text-lm-on-surface mb-1">
            Hola, {{ $summary['name'] }} 👋
        </h1>
        <p class="text-sm text-lm-on-surface-variant">
            Bienvenido a tu espacio personal. Desde acá gestionás tu perfil, tus postulaciones y tus mensajes.
        </p>
    </div>

    {{-- Grid 70/30 --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- Columna principal (~70%) --}}
        <div class="lg:col-span-2 flex flex-col gap-6">

            {{-- Accesos rápidos --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                {{-- Mi Perfil (edición) --}}
                <a href="{{ route('profile.edit.candidate') }}" wire:navigate
                   class="bg-white rounded-xl border border-lm-outline-variant px-5 py-5 flex flex-col gap-3 hover:shadow-sm transition-shadow">
                    <div class="w-10 h-10 rounded-lg bg-lm-secondary-container flex items-center justify-center">
                        <span class="material-symbols-outlined text-xl leading-none text-lm-primary">person</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-lm-on-surface">Mi Perfil</p>
                        <p class="text-xs mt-0.5 text-lm-outline">Editá tu experiencia, habilidades y datos</p>
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

                {{-- Mi CV (carga de archivos) --}}
                <a href="{{ route('profile.edit.candidate') }}#cv" wire:navigate
                   class="bg-white rounded-xl border border-lm-outline-variant px-5 py-5 flex flex-col gap-3 hover:shadow-sm transition-shadow">
                    <div class="w-10 h-10 rounded-lg bg-lm-secondary-container flex items-center justify-center">
                        <span class="material-symbols-outlined text-xl leading-none text-lm-primary">description</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-lm-on-surface">Mi CV</p>
                        <p class="text-xs mt-0.5 text-lm-outline">
                            {{ $summary['has_cv'] ? 'Reemplazá tu currículum en PDF' : 'Subí tu currículum en PDF' }}
                        </p>
                    </div>
                    @if ($summary['has_cv'])
                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full w-fit bg-green-50 text-green-700 flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs leading-none">check_circle</span> CV cargado
                        </span>
                    @else
                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full w-fit bg-lm-secondary-container text-lm-primary">
                            Subir ahora
                        </span>
                    @endif
                </a>

                {{-- Buscar Ofertas --}}
                <a href="{{ route('jobs.search') }}" wire:navigate
                   class="bg-white rounded-xl border border-lm-outline-variant px-5 py-5 flex flex-col gap-3 hover:shadow-sm transition-shadow">
                    <div class="w-10 h-10 rounded-lg bg-lm-secondary-container flex items-center justify-center">
                        <span class="material-symbols-outlined text-xl leading-none text-lm-primary">search</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-lm-on-surface">Buscar Ofertas</p>
                        <p class="text-xs mt-0.5 text-lm-outline">Explorá trabajos que se ajusten a tu perfil</p>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full w-fit bg-lm-secondary-container text-lm-primary">
                        Explorar
                    </span>
                </a>

                {{-- Mis Postulaciones --}}
                <a href="{{ route('applications.index') }}" wire:navigate
                   class="bg-white rounded-xl border border-lm-outline-variant px-5 py-5 flex flex-col gap-3 hover:shadow-sm transition-shadow">
                    <div class="w-10 h-10 rounded-lg bg-lm-secondary-container flex items-center justify-center">
                        <span class="material-symbols-outlined text-xl leading-none text-lm-primary">work</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-lm-on-surface">Mis Postulaciones</p>
                        <p class="text-xs mt-0.5 text-lm-outline">Seguí el estado de cada oferta aplicada</p>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full w-fit bg-lm-secondary-container text-lm-primary">
                        Ver postulaciones
                    </span>
                </a>

                {{-- Mensajes --}}
                <a href="{{ route('conversations.index') }}" wire:navigate
                   class="bg-white rounded-xl border border-lm-outline-variant px-5 py-5 flex flex-col gap-3 hover:shadow-sm transition-shadow">
                    <div class="w-10 h-10 rounded-lg bg-lm-secondary-container flex items-center justify-center">
                        <span class="material-symbols-outlined text-xl leading-none text-lm-primary">chat</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-lm-on-surface">Mensajes</p>
                        <p class="text-xs mt-0.5 text-lm-outline">Conversaciones con las empresas</p>
                    </div>
                    <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full w-fit bg-lm-secondary-container text-lm-primary">
                        Ver mensajes
                    </span>
                </a>

            </div>
        </div>

        {{-- Sidebar de perfil (~30%, derecha) --}}
        <aside class="flex flex-col gap-6 lg:sticky lg:top-6">

            {{-- Resumen de perfil --}}
            <div class="bg-white rounded-xl border border-lm-outline-variant px-6 py-5 flex flex-col gap-4">
                <div class="flex items-start gap-4">

                    {{-- Avatar --}}
                    <div class="w-14 h-14 rounded-full overflow-hidden flex items-center justify-center shrink-0 bg-lm-secondary-container">
                        @if ($summary['avatar_url'])
                            <img src="{{ $summary['avatar_url'] }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            <span class="text-lg font-bold text-lm-primary">{{ $summary['initials'] }}</span>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold truncate text-lm-on-surface">{{ $summary['name'] }}</p>
                        @if ($summary['headline'])
                            <p class="text-xs mt-0.5 truncate text-lm-on-surface-variant">{{ $summary['headline'] }}</p>
                        @else
                            <p class="text-xs mt-0.5 text-lm-outline">Sin titular</p>
                        @endif
                        @if ($summary['city'])
                            <p class="text-xs mt-1 flex items-center gap-1 text-lm-outline">
                                <span class="material-symbols-outlined text-sm leading-none">location_on</span>
                                {{ $summary['city'] }}{{ $summary['province'] ? ', ' . $summary['province'] : '' }}
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Badges --}}
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-xs px-2.5 py-0.5 rounded-full font-semibold bg-lm-secondary-container text-lm-primary">
                        {{ $summary['skills_count'] }} {{ $summary['skills_count'] === 1 ? 'habilidad' : 'habilidades' }}
                    </span>
                    @if ($summary['has_cv'])
                        <span class="text-xs px-2.5 py-0.5 rounded-full font-semibold bg-lm-secondary-container text-lm-primary flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs leading-none">description</span> CV cargado
                        </span>
                    @else
                        <span class="text-xs px-2.5 py-0.5 rounded-full font-semibold bg-lm-surface-highest text-lm-secondary">
                            Sin CV
                        </span>
                    @endif
                </div>

                {{-- Barra de completitud --}}
                <div class="flex flex-col gap-1">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-lm-secondary">Perfil completo</span>
                        <span class="text-xs font-semibold text-lm-primary">{{ $percentage }}%</span>
                    </div>
                    <div class="w-full h-2 rounded-full overflow-hidden bg-lm-surface-highest">
                        <div class="h-2 rounded-full transition-all"
                             style="width:{{ $percentage }}%; background-color:{{ $percentage >= 70 ? '#006d36' : '#003d9b' }};"></div>
                    </div>
                </div>

                <a href="{{ route('profile.edit.candidate') }}" wire:navigate
                   class="self-start text-xs font-semibold px-4 py-2 rounded-lg border border-lm-primary text-lm-primary hover:bg-lm-secondary-container transition-colors">
                    Editar perfil
                </a>
            </div>

            {{-- Checklist de completitud --}}
            @if (count($pending) > 0)
                <div class="bg-white rounded-xl border border-lm-outline-variant px-6 py-5 flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-bold text-lm-on-surface">Completá tu perfil</h2>
                        <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-lm-secondary-container text-lm-primary">
                            {{ count($pending) }} {{ count($pending) === 1 ? 'pendiente' : 'pendientes' }}
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        @foreach ($items as $item)
                            <div @class([
                                'flex items-center gap-3 px-3 py-2.5 rounded-lg border',
                                'border-green-200 bg-green-50' => $item['done'],
                                'border-lm-surface-highest bg-lm-surface-low' => ! $item['done'],
                            ])>
                                <div @class([
                                    'w-7 h-7 rounded-full flex items-center justify-center shrink-0',
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
                                        'text-xs font-semibold',
                                        'text-green-700' => $item['done'],
                                        'text-lm-on-surface' => ! $item['done'],
                                    ])>{{ $item['label'] }}</p>
                                    @if (! $item['done'])
                                        <p class="text-xs mt-0.5 text-lm-outline leading-tight">{{ $item['description'] }}</p>
                                    @endif
                                </div>

                                @if (! $item['done'])
                                    <a href="{{ route('profile.edit.candidate') }}#{{ $item['anchor'] }}" wire:navigate
                                       class="text-xs font-semibold px-2.5 py-1 rounded-lg shrink-0 text-white transition-opacity hover:opacity-80"
                                       style="background-color:#003d9b;">
                                        Ir
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="flex items-center gap-3 px-5 py-4 rounded-xl border border-green-200 bg-green-50">
                    <div class="w-9 h-9 rounded-full bg-green-600 flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-lg text-white leading-none">verified</span>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-green-700">Perfil completo</p>
                        <p class="text-xs mt-0.5 text-lm-on-surface-variant">Visible para las empresas.</p>
                    </div>
                </div>
            @endif

        </aside>

    </div>

</div>
