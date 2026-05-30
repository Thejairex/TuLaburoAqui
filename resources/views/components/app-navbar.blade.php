<header class="bg-white border-b border-lm-outline-variant sticky top-0 z-30 h-16"
        x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 md:px-8 h-full grid grid-cols-[auto_1fr_auto] items-center gap-4">

        {{-- Logo --}}
        <a href="{{ route('dashboard') }}" wire:navigate
           class="font-hanken font-bold text-lm-primary text-lg shrink-0">
            TuLaburoAquí
        </a>

        {{-- Nav links — desktop (centrado) --}}
        <nav class="hidden md:flex items-center justify-center h-full gap-0">

            <a href="{{ route('dashboard') }}" wire:navigate
               @class([
                   'flex items-center px-4 h-full text-sm font-semibold transition-colors border-b-2',
                   'border-lm-primary text-lm-primary' => request()->routeIs('dashboard*'),
                   'border-transparent text-lm-on-surface-variant hover:text-lm-on-surface' => ! request()->routeIs('dashboard*'),
               ])>
                Dashboard
            </a>

            @if(auth()->user()?->role === 'candidate')
                <a href="{{ route('profile.edit.candidate') }}" wire:navigate
                   @class([
                       'flex items-center px-4 h-full text-sm font-semibold transition-colors border-b-2',
                       'border-lm-primary text-lm-primary' => request()->routeIs('profile.edit.candidate'),
                       'border-transparent text-lm-on-surface-variant hover:text-lm-on-surface' => ! request()->routeIs('profile.edit.candidate'),
                   ])>
                    Mi Perfil
                </a>
            @endif

            @if(auth()->user()?->role === 'employer')
                <a href="{{ route('company.edit') }}" wire:navigate
                   @class([
                       'flex items-center px-4 h-full text-sm font-semibold transition-colors border-b-2',
                       'border-lm-primary text-lm-primary' => request()->routeIs('company.edit'),
                       'border-transparent text-lm-on-surface-variant hover:text-lm-on-surface' => ! request()->routeIs('company.edit'),
                   ])>
                    Mi Empresa
                </a>

                <a href="{{ route('company.jobs.index') }}" wire:navigate
                   @class([
                       'flex items-center px-4 h-full text-sm font-semibold transition-colors border-b-2',
                       'border-lm-primary text-lm-primary' => request()->routeIs('company.jobs.*'),
                       'border-transparent text-lm-on-surface-variant hover:text-lm-on-surface' => ! request()->routeIs('company.jobs.*'),
                   ])>
                    Mis Ofertas
                </a>
            @endif

            @if(auth()->user()?->role === 'candidate')
                <a href="{{ route('jobs.search') }}" wire:navigate
                   @class([
                       'flex items-center px-4 h-full text-sm font-semibold transition-colors border-b-2',
                       'border-lm-primary text-lm-primary' => request()->routeIs('jobs.*'),
                       'border-transparent text-lm-on-surface-variant hover:text-lm-on-surface' => ! request()->routeIs('jobs.*'),
                   ])>
                    Buscar Ofertas
                </a>
            @endif

            @if(auth()->user()?->role === 'candidate')
                <span class="flex items-center gap-1.5 px-4 h-full text-sm font-semibold text-lm-outline cursor-not-allowed select-none opacity-40 border-b-2 border-transparent">
                    Postulaciones
                    <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-full bg-lm-surface-highest text-lm-secondary">Pronto</span>
                </span>
            @endif

            @if(auth()->user()?->role === 'employer')
                <span class="flex items-center gap-1.5 px-4 h-full text-sm font-semibold text-lm-outline cursor-not-allowed select-none opacity-40 border-b-2 border-transparent">
                    Candidatos
                    <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-full bg-lm-surface-highest text-lm-secondary">Pronto</span>
                </span>
            @endif
        </nav>

        {{-- Derecha: avatar + dropdown (desktop) + burger (mobile) --}}
        <div class="flex items-center gap-2">

            {{-- Avatar + dropdown — desktop --}}
            <div class="hidden md:block relative" x-data="{ open: false }">
                <button @click="open = !open" @click.outside="open = false"
                        class="flex items-center gap-2 rounded-full hover:ring-2 hover:ring-lm-outline-variant transition-all p-0.5">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-lm-secondary-container overflow-hidden">
                        @if(auth()->user()?->avatarUrl())
                            <img src="{{ auth()->user()->avatarUrl() }}" alt="" class="w-full h-full object-cover">
                        @else
                            <span class="text-xs font-bold text-lm-primary">{{ auth()->user()?->initials() }}</span>
                        @endif
                    </div>
                    <span class="material-symbols-outlined text-base leading-none text-lm-outline">expand_more</span>
                </button>

                <div x-show="open"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 top-full mt-2 w-56 bg-white border border-lm-outline-variant rounded-xl shadow-lg overflow-hidden z-50"
                     style="display:none;">

                    <div class="px-4 py-3 border-b border-lm-surface-highest">
                        <p class="text-sm font-semibold text-lm-on-surface">{{ auth()->user()?->name }}</p>
                        <p class="text-xs text-lm-outline truncate mt-0.5">{{ auth()->user()?->email }}</p>
                    </div>

                    <div class="py-1">
                        <a href="{{ route('profile.edit') }}" wire:navigate @click="open = false"
                           class="flex items-center gap-2.5 px-4 py-2 text-sm text-lm-on-surface-variant hover:bg-lm-surface-low hover:text-lm-on-surface transition-colors">
                            <span class="material-symbols-outlined text-[18px] leading-none">settings</span>
                            Configuración
                        </a>
                    </div>

                    <div class="py-1 border-t border-lm-surface-highest">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-lm-on-surface-variant hover:bg-lm-surface-low hover:text-lm-on-surface transition-colors">
                                <span class="material-symbols-outlined text-[18px] leading-none">logout</span>
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Burger — mobile --}}
            <button @click="mobileOpen = !mobileOpen"
                    class="md:hidden p-2 rounded-lg text-lm-on-surface-variant hover:bg-lm-surface-low transition-colors">
                <span class="material-symbols-outlined text-xl leading-none"
                      x-text="mobileOpen ? 'close' : 'menu'">menu</span>
            </button>
        </div>
    </div>

    {{-- Nav móvil --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden absolute top-16 left-0 right-0 bg-white border-b border-lm-outline-variant shadow-md px-4 py-3 flex flex-col gap-1"
         style="display:none;">

        <a href="{{ route('dashboard') }}" wire:navigate @click="mobileOpen = false"
           @class([
               'flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors',
               'text-lm-primary bg-lm-secondary-container' => request()->routeIs('dashboard*'),
               'text-lm-on-surface-variant hover:bg-lm-surface-low hover:text-lm-on-surface' => ! request()->routeIs('dashboard*'),
           ])>
            <span class="material-symbols-outlined text-[18px] leading-none">dashboard</span>
            Dashboard
        </a>

        @if(auth()->user()?->role === 'candidate')
            <a href="{{ route('profile.edit.candidate') }}" wire:navigate @click="mobileOpen = false"
               @class([
                   'flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors',
                   'text-lm-primary bg-lm-secondary-container' => request()->routeIs('profile.edit.candidate'),
                   'text-lm-on-surface-variant hover:bg-lm-surface-low hover:text-lm-on-surface' => ! request()->routeIs('profile.edit.candidate'),
               ])>
                <span class="material-symbols-outlined text-[18px] leading-none">person</span>
                Mi Perfil
            </a>

            <a href="{{ route('jobs.search') }}" wire:navigate @click="mobileOpen = false"
               @class([
                   'flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors',
                   'text-lm-primary bg-lm-secondary-container' => request()->routeIs('jobs.*'),
                   'text-lm-on-surface-variant hover:bg-lm-surface-low hover:text-lm-on-surface' => ! request()->routeIs('jobs.*'),
               ])>
                <span class="material-symbols-outlined text-[18px] leading-none">search</span>
                Buscar Ofertas
            </a>
        @endif

        @if(auth()->user()?->role === 'employer')
            <a href="{{ route('company.edit') }}" wire:navigate @click="mobileOpen = false"
               @class([
                   'flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors',
                   'text-lm-primary bg-lm-secondary-container' => request()->routeIs('company.edit'),
                   'text-lm-on-surface-variant hover:bg-lm-surface-low hover:text-lm-on-surface' => ! request()->routeIs('company.edit'),
               ])>
                <span class="material-symbols-outlined text-[18px] leading-none">business</span>
                Mi Empresa
            </a>

            <a href="{{ route('company.jobs.index') }}" wire:navigate @click="mobileOpen = false"
               @class([
                   'flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors',
                   'text-lm-primary bg-lm-secondary-container' => request()->routeIs('company.jobs.*'),
                   'text-lm-on-surface-variant hover:bg-lm-surface-low hover:text-lm-on-surface' => ! request()->routeIs('company.jobs.*'),
               ])>
                <span class="material-symbols-outlined text-[18px] leading-none">work</span>
                Mis Ofertas
            </a>
        @endif

        <div class="border-t border-lm-surface-highest mt-1 pt-2">
            <div class="flex items-center gap-3 px-3 py-2">
                <div class="w-8 h-8 rounded-full bg-lm-secondary-container flex items-center justify-center overflow-hidden">
                    @if(auth()->user()?->avatarUrl())
                        <img src="{{ auth()->user()->avatarUrl() }}" alt="" class="w-full h-full object-cover">
                    @else
                        <span class="text-xs font-bold text-lm-primary">{{ auth()->user()?->initials() }}</span>
                    @endif
                </div>
                <div>
                    <p class="text-sm font-semibold text-lm-on-surface">{{ auth()->user()?->name }}</p>
                    <p class="text-xs text-lm-outline">{{ auth()->user()?->email }}</p>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" wire:navigate @click="mobileOpen = false"
               class="flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm font-semibold text-lm-on-surface-variant hover:bg-lm-surface-low transition-colors">
                <span class="material-symbols-outlined text-[18px] leading-none">settings</span>
                Configuración
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-sm font-semibold text-lm-on-surface-variant hover:bg-lm-surface-low transition-colors">
                    <span class="material-symbols-outlined text-[18px] leading-none">logout</span>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</header>
