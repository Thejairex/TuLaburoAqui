<x-layouts::app :title="__('Panel de empresa')">
    @php
        $company = auth()->user()->load('companyMemberships.company')->companyMemberships->first()?->company;
    @endphp

    <div class="flex flex-col gap-6 p-6">

        {{-- Bienvenida --}}
        <div class="rounded-xl border p-6" style="background-color:#ffffff; border-color:#c3c6d6;">
            <p class="text-xs font-semibold tracking-wider uppercase mb-1" style="color:#737685;">Empleador</p>
            <h1 class="text-2xl font-bold mb-1" style="color:#191c1e;">
                Hola, {{ auth()->user()->name }} 👋
            </h1>
            <p class="text-sm" style="color:#434654;">
                @if ($company)
                    Estás gestionando <span class="font-semibold">{{ $company->legal_name }}</span>. Desde acá publicás ofertas, revisás postulaciones y administrás tu empresa.
                @else
                    Bienvenido a tu panel de empresa. Desde acá vas a gestionar ofertas, postulaciones y el perfil de tu empresa.
                @endif
            </p>
        </div>

        {{-- Cards de acciones próximas --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div class="rounded-xl border p-5 flex flex-col gap-3" style="background-color:#ffffff; border-color:#c3c6d6;">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color:#d3e2ed;">
                    <span class="material-symbols-outlined text-xl" style="color:#003d9b;">business</span>
                </div>
                <div>
                    <p class="text-sm font-semibold" style="color:#191c1e;">Perfil de empresa</p>
                    <p class="text-xs mt-0.5" style="color:#737685;">Completá logo, industria, tamaño y descripción</p>
                </div>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full w-fit" style="background-color:#e1e2e4; color:#526069;">Próximamente</span>
            </div>

            <div class="rounded-xl border p-5 flex flex-col gap-3" style="background-color:#ffffff; border-color:#c3c6d6;">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color:#d3e2ed;">
                    <span class="material-symbols-outlined text-xl" style="color:#003d9b;">post_add</span>
                </div>
                <div>
                    <p class="text-sm font-semibold" style="color:#191c1e;">Publicar oferta</p>
                    <p class="text-xs mt-0.5" style="color:#737685;">Creá una nueva búsqueda laboral</p>
                </div>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full w-fit" style="background-color:#e1e2e4; color:#526069;">Próximamente</span>
            </div>

            <div class="rounded-xl border p-5 flex flex-col gap-3" style="background-color:#ffffff; border-color:#c3c6d6;">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color:#d3e2ed;">
                    <span class="material-symbols-outlined text-xl" style="color:#003d9b;">group</span>
                </div>
                <div>
                    <p class="text-sm font-semibold" style="color:#191c1e;">Candidatos</p>
                    <p class="text-xs mt-0.5" style="color:#737685;">Revisá postulaciones a tus ofertas</p>
                </div>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full w-fit" style="background-color:#e1e2e4; color:#526069;">Próximamente</span>
            </div>

        </div>

    </div>
</x-layouts::app>
