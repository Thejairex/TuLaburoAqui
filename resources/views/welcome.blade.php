<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'LaborMarket') }} | Encuentra trabajo hoy mismo</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Hanken Grotesk', ui-sans-serif, system-ui, sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
    </style>
</head>
<body class="bg-lm-surface text-lm-on-surface antialiased">

    {{-- Navbar --}}
    <header class="w-full top-0 sticky z-50 bg-lm-surface-lowest border-b border-lm-outline-variant">
        <div class="flex justify-between items-center px-8 h-16 w-full max-w-[1200px] mx-auto">
            <div class="flex items-center gap-10">
                <span class="text-[32px] font-bold leading-10 tracking-tight text-lm-primary">
                    {{ config('app.name', 'LaborMarket') }}
                </span>
                <nav class="hidden md:flex gap-6">
                    <a href="#empleos" class="text-sm font-bold text-lm-primary border-b-2 border-lm-primary pb-1">
                        Buscar empleos
                    </a>
                    <a href="#talento" class="text-sm text-lm-secondary hover:text-lm-primary transition-colors">
                        Talento disponible
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm text-lm-secondary hover:text-lm-primary transition-colors">
                            Dashboard
                        </a>
                    @endauth
                </nav>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="px-6 py-2 text-xs font-semibold tracking-wider uppercase bg-lm-primary text-lm-on-primary rounded-lg hover:opacity-90 transition-opacity">
                        Mi cuenta
                    </a>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}"
                           class="px-6 py-2 text-xs font-semibold tracking-wider uppercase text-lm-primary hover:bg-lm-surface-low transition-colors rounded">
                            Iniciar sesión
                        </a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-6 py-2 text-xs font-semibold tracking-wider uppercase bg-lm-secondary-fixed text-lm-primary hover:bg-lm-secondary-container transition-colors rounded-lg">
                            Publicar oferta
                        </a>
                        <a href="{{ route('register') }}"
                           class="px-6 py-2 text-xs font-semibold tracking-wider uppercase bg-lm-primary text-lm-on-primary hover:opacity-90 transition-opacity rounded-lg">
                            Registrarse
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <main class="w-full">

        {{-- Hero --}}
        <section class="w-full bg-lm-surface-lowest py-16 px-4 md:px-8">
            <div class="max-w-[1200px] mx-auto text-center space-y-6">
                <h1 class="text-[32px] md:text-[48px] font-bold leading-tight tracking-tight text-lm-on-surface max-w-[800px] mx-auto">
                    Encuentra trabajo hoy mismo
                </h1>
                <p class="text-base text-lm-secondary max-w-[600px] mx-auto">
                    La plataforma más rápida y confiable para empleos operativos en logística, retail y servicios.
                </p>

                {{-- Buscador --}}
                <form method="GET" action="{{ route('jobs.search') }}"
                      class="mt-10 bg-white p-3 rounded-xl border border-lm-outline-variant shadow-sm max-w-[900px] mx-auto flex flex-col md:flex-row gap-1 items-center">
                    <div class="flex items-center gap-2 px-3 w-full md:border-r border-lm-outline-variant">
                        <span class="material-symbols-outlined text-lm-outline text-xl">search</span>
                        <input type="text" name="q" placeholder="¿Qué trabajo buscás?"
                               class="w-full border-none focus:ring-0 text-sm bg-transparent placeholder:text-lm-outline">
                    </div>
                    <div class="flex items-center gap-2 px-3 w-full md:border-r border-lm-outline-variant">
                        <span class="material-symbols-outlined text-lm-outline text-xl">location_on</span>
                        <input type="text" name="lugar" placeholder="Ubicación"
                               class="w-full border-none focus:ring-0 text-sm bg-transparent placeholder:text-lm-outline">
                    </div>
                    <div class="flex items-center gap-2 px-3 w-full">
                        <span class="material-symbols-outlined text-lm-outline text-xl">schedule</span>
                        <select name="contrato[]" class="w-full border-none focus:ring-0 text-sm bg-transparent text-lm-secondary">
                            <option value="">Disponibilidad</option>
                            <option value="full-time">Tiempo Completo</option>
                            <option value="part-time">Medio Tiempo</option>
                            <option value="contract">Contrato</option>
                            <option value="freelance">Freelance</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full md:w-auto px-16 py-3 bg-lm-primary text-lm-on-primary text-xs font-semibold tracking-wider uppercase rounded-lg hover:opacity-90 transition-all whitespace-nowrap">
                        Buscar trabajo
                    </button>
                </form>

                {{-- Tags populares --}}
                <div class="flex flex-wrap justify-center gap-2 mt-6">
                    @foreach(['Repartidor', 'Almacén', 'Atención al cliente', 'Limpieza', 'Seguridad'] as $tag)
                        <a href="{{ route('jobs.search', ['q' => $tag]) }}"
                           class="px-3 py-1 bg-lm-secondary-fixed text-lm-on-secondary-fixed-variant rounded-full text-xs font-semibold tracking-wider uppercase hover:bg-lm-secondary-container transition-colors">
                            {{ $tag }}
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Ofertas Destacadas --}}
        <section id="empleos" class="max-w-[1200px] mx-auto py-16 px-4 md:px-8">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-xl font-semibold text-lm-on-surface">Ofertas destacadas</h2>
                    <p class="text-sm text-lm-secondary">Las últimas publicaciones disponibles</p>
                </div>
                <a href="{{ route('jobs.search') }}"
                   class="text-lm-primary text-xs font-semibold tracking-wider uppercase hover:underline">
                    Ver todas las ofertas
                </a>
            </div>

            @php
                $categoryEmoji = [
                    'Tecnología'    => '💻',
                    'Logística'     => '🚚',
                    'Ventas'        => '🛒',
                    'Construcción'  => '🏗️',
                    'Administración'=> '📋',
                    'Retail'        => '🏪',
                ];
                $modalityIcon = [
                    'remote'  => ['icon' => 'home_work',    'label' => 'Trabajo remoto'],
                    'on-site' => ['icon' => 'location_on',  'label' => 'Presencial'],
                    'hybrid'  => ['icon' => 'sync_alt',     'label' => 'Modalidad híbrida'],
                ];
                $seniorityIcon = [
                    'junior' => ['icon' => 'school',             'label' => 'Junior'],
                    'mid'    => ['icon' => 'verified',            'label' => 'Semi Senior'],
                    'senior' => ['icon' => 'workspace_premium',   'label' => 'Senior'],
                    'lead'   => ['icon' => 'military_tech',       'label' => 'Lead'],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($featuredJobs as $job)
                    @php
                        $emoji    = $categoryEmoji[$job->category] ?? '💼';
                        $modality = $modalityIcon[$job->work_modality] ?? null;
                        $seniority= $seniorityIcon[$job->seniority] ?? null;
                        $badge    = $modality ?? $seniority ?? ['icon' => 'work', 'label' => 'Oferta activa'];
                        $company  = $job->company?->display_name ?? $job->company?->legal_name ?? '—';
                    @endphp
                    <a href="{{ route('jobs.show', $job) }}"
                       class="bg-white p-6 rounded-xl border border-lm-outline-variant hover:shadow-md transition-all group cursor-pointer block"
                       style="transition: transform 0.2s ease, box-shadow 0.2s ease;"
                       onmouseenter="this.style.transform='translateY(-4px)'"
                       onmouseleave="this.style.transform='translateY(0)'">
                        <div class="flex justify-between items-start mb-3">
                            <div class="h-12 w-12 bg-lm-surface-container rounded-lg flex items-center justify-center text-2xl">
                                {{ $emoji }}
                            </div>
                            @if ($job->salary_visible && $job->salary_min)
                                <span class="text-lm-on-tertiary-fixed-variant text-xs font-semibold tracking-wider bg-lm-tertiary-fixed px-3 py-1 rounded-full">
                                    ${{ number_format($job->salary_min, 0, ',', '.') }} / mes
                                </span>
                            @else
                                <span class="text-lm-secondary text-xs font-semibold tracking-wider bg-lm-surface-highest px-3 py-1 rounded-full">
                                    A convenir
                                </span>
                            @endif
                        </div>
                        <h3 class="text-xl font-semibold text-lm-on-surface group-hover:text-lm-primary transition-colors">
                            {{ $job->title }}
                        </h3>
                        <p class="text-sm text-lm-secondary mb-6">
                            {{ $company }}@if($job->city) • {{ $job->city }}@endif
                        </p>
                        <div class="flex gap-2 mb-6">
                            <span class="material-symbols-outlined text-lm-outline text-[18px]">{{ $badge['icon'] }}</span>
                            <span class="text-xs font-semibold tracking-wider uppercase text-lm-outline">{{ $badge['label'] }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-6 border-t border-lm-outline-variant">
                            <span class="text-xs font-semibold text-lm-secondary">
                                {{ $job->published_at?->diffForHumans() ?? 'Reciente' }}
                            </span>
                            <span class="text-xs font-bold text-lm-primary group-hover:underline">Ver oferta</span>
                        </div>
                    </a>
                @empty
                    <p class="col-span-3 text-sm text-center text-lm-outline py-8">No hay ofertas publicadas por el momento.</p>
                @endforelse
            </div>
        </section>

        {{-- Talento disponible --}}
        <section id="talento" class="w-full bg-lm-surface-low py-16">
            <div class="max-w-[1200px] mx-auto px-4 md:px-8">
                <div class="flex justify-between items-end mb-10">
                    <div>
                        <h2 class="text-xl font-semibold text-lm-on-surface">Talento disponible</h2>
                        <p class="text-sm text-lm-secondary">Candidatos destacados en tu área</p>
                    </div>
                    <button class="text-lm-primary text-xs font-semibold tracking-wider uppercase hover:underline">
                        Explorar perfiles
                    </button>
                </div>

                <div class="flex flex-col md:flex-row gap-6">
                    <div class="flex-1 bg-white p-6 rounded-xl border border-lm-outline-variant flex items-center gap-6 hover:border-lm-primary transition-colors cursor-pointer">
                        <div class="relative shrink-0">
                            <div class="h-16 w-16 rounded-full bg-lm-surface-container flex items-center justify-center text-3xl">
                                👷
                            </div>
                            <div class="absolute bottom-0 right-0 h-4 w-4 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xl font-semibold text-lm-on-surface">Roberto García</h4>
                            <p class="text-sm text-lm-secondary">Montacarguista • 5 años exp.</p>
                            <div class="flex gap-1 mt-1 items-center">
                                <span class="material-symbols-outlined text-lm-primary text-[16px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="text-xs font-semibold text-lm-on-surface">4.9 (42 reseñas)</span>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-lm-outline shrink-0">chevron_right</span>
                    </div>

                    <div class="flex-1 bg-white p-6 rounded-xl border border-lm-outline-variant flex items-center gap-6 hover:border-lm-primary transition-colors cursor-pointer">
                        <div class="relative shrink-0">
                            <div class="h-16 w-16 rounded-full bg-lm-surface-container flex items-center justify-center text-3xl">
                                💼
                            </div>
                            <div class="absolute bottom-0 right-0 h-4 w-4 bg-green-500 border-2 border-white rounded-full"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xl font-semibold text-lm-on-surface">Elena Martínez</h4>
                            <p class="text-sm text-lm-secondary">Atención al Cliente • Bilingüe</p>
                            <div class="flex gap-1 mt-1 items-center">
                                <span class="material-symbols-outlined text-lm-primary text-[16px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="text-xs font-semibold text-lm-on-surface">5.0 (18 reseñas)</span>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-lm-outline shrink-0">chevron_right</span>
                    </div>
                </div>
            </div>
        </section>

        {{-- CTA Empleadores --}}
        <section class="w-full py-16 px-4 md:px-8 text-center">
            <div class="max-w-[800px] mx-auto bg-lm-primary rounded-2xl p-16 text-lm-on-primary">
                <h2 class="text-2xl md:text-[32px] font-bold leading-tight tracking-tight mb-3">
                    ¿Buscás contratar personal?
                </h2>
                <p class="text-base text-lm-primary-fixed opacity-90 mb-10">
                    Publicá tu vacante en menos de 2 minutos y recibí candidatos calificados hoy mismo.
                </p>
                <div class="flex flex-col md:flex-row gap-3 justify-center">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-16 py-3 bg-white text-lm-primary font-semibold text-xl rounded-lg hover:bg-lm-surface-low transition-colors">
                            Publicar Oferta
                        </a>
                    @endif
                    <button class="px-16 py-3 border border-white text-lm-on-primary font-semibold text-xl rounded-lg hover:bg-lm-primary-container transition-colors">
                        Saber más
                    </button>
                </div>
            </div>
        </section>

    </main>

    {{-- Footer --}}
    <footer class="w-full mt-10 border-t border-lm-outline-variant bg-lm-surface-low">
        <div class="w-full py-6 px-8 flex flex-col md:flex-row justify-between items-center max-w-[1200px] mx-auto">
            <div class="flex flex-col gap-1 mb-6 md:mb-0">
                <span class="text-xl font-semibold text-lm-primary">{{ config('app.name', 'LaborMarket') }}</span>
                <p class="text-xs font-semibold tracking-wider text-lm-secondary">© {{ date('Y') }} {{ config('app.name', 'LaborMarket') }} Platform. Todos los derechos reservados.</p>
            </div>
            <div class="flex gap-6 flex-wrap justify-center">
                <a href="#" class="text-xs font-semibold tracking-wider text-lm-on-surface-variant hover:text-lm-primary transition-colors">Términos de servicio</a>
                <a href="#" class="text-xs font-semibold tracking-wider text-lm-on-surface-variant hover:text-lm-primary transition-colors">Privacidad</a>
                <a href="#" class="text-xs font-semibold tracking-wider text-lm-on-surface-variant hover:text-lm-primary transition-colors">Centro de ayuda</a>
                <a href="#" class="text-xs font-semibold tracking-wider text-lm-on-surface-variant hover:text-lm-primary transition-colors">Soporte</a>
            </div>
        </div>
    </footer>

</body>
</html>
