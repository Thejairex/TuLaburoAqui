<x-layouts::app :title="__('Mi espacio')">
    <div class="flex flex-col gap-6 p-6">

        {{-- Bienvenida --}}
        <div class="rounded-xl border p-6" style="background-color:#ffffff; border-color:#c3c6d6;">
            <p class="text-xs font-semibold tracking-wider uppercase mb-1" style="color:#737685;">Candidato</p>
            <h1 class="text-2xl font-bold mb-1" style="color:#191c1e;">
                Hola, {{ auth()->user()->name }} 👋
            </h1>
            <p class="text-sm" style="color:#434654;">
                Bienvenido a tu espacio personal. Desde acá vas a gestionar tu perfil, tus postulaciones y tus mensajes.
            </p>
        </div>

        {{-- Cards de acciones próximas --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div class="rounded-xl border p-5 flex flex-col gap-3" style="background-color:#ffffff; border-color:#c3c6d6;">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color:#d3e2ed;">
                    <span class="material-symbols-outlined text-xl" style="color:#003d9b;">person</span>
                </div>
                <div>
                    <p class="text-sm font-semibold" style="color:#191c1e;">Mi perfil</p>
                    <p class="text-xs mt-0.5" style="color:#737685;">Completá tu experiencia, habilidades y CV</p>
                </div>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full w-fit" style="background-color:#e1e2e4; color:#526069;">Próximamente</span>
            </div>

            <div class="rounded-xl border p-5 flex flex-col gap-3" style="background-color:#ffffff; border-color:#c3c6d6;">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color:#d3e2ed;">
                    <span class="material-symbols-outlined text-xl" style="color:#003d9b;">work</span>
                </div>
                <div>
                    <p class="text-sm font-semibold" style="color:#191c1e;">Mis postulaciones</p>
                    <p class="text-xs mt-0.5" style="color:#737685;">Seguí el estado de cada oferta aplicada</p>
                </div>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full w-fit" style="background-color:#e1e2e4; color:#526069;">Próximamente</span>
            </div>

            <div class="rounded-xl border p-5 flex flex-col gap-3" style="background-color:#ffffff; border-color:#c3c6d6;">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color:#d3e2ed;">
                    <span class="material-symbols-outlined text-xl" style="color:#003d9b;">search</span>
                </div>
                <div>
                    <p class="text-sm font-semibold" style="color:#191c1e;">Buscar ofertas</p>
                    <p class="text-xs mt-0.5" style="color:#737685;">Explorá trabajos que se ajusten a tu perfil</p>
                </div>
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full w-fit" style="background-color:#e1e2e4; color:#526069;">Próximamente</span>
            </div>

        </div>

    </div>
</x-layouts::app>
