<div class="max-w-4xl mx-auto px-6 py-10 flex flex-col gap-6">

    {{-- Header con logo y datos principales --}}
    <div class="rounded-xl border p-6 flex flex-col md:flex-row gap-6 items-start" style="background-color:#ffffff; border-color:#c3c6d6;">
        {{-- Logo --}}
        <div class="w-24 h-24 rounded-xl overflow-hidden flex items-center justify-center shrink-0 border" style="background-color:#f3f4f6; border-color:#c3c6d6;">
            @if ($company->logoUrl())
                <img src="{{ $company->logoUrl() }}" alt="{{ $company->display_name ?? $company->legal_name }}" class="w-full h-full object-cover">
            @else
                <span class="material-symbols-outlined text-4xl" style="color:#526069;">business</span>
            @endif
        </div>

        <div class="flex-1 flex flex-col gap-2">
            <div>
                <h1 class="text-2xl font-bold" style="color:#191c1e;">
                    {{ $company->display_name ?? $company->legal_name }}
                </h1>
                @if ($company->display_name && $company->legal_name !== $company->display_name)
                    <p class="text-xs mt-0.5" style="color:#737685;">{{ $company->legal_name }}</p>
                @endif
            </div>

            <div class="flex flex-wrap gap-2 mt-1">
                @if ($company->ratings_count > 0 && $company->avg_rating)
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full flex items-center gap-1" style="background-color:#fef9c3; color:#854d0e;">
                        <span class="material-symbols-outlined text-xs">star</span>
                        {{ number_format($company->avg_rating, 1) }} ({{ $company->ratings_count }})
                    </span>
                @endif
                @if ($company->industry)
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full" style="background-color:#d3e2ed; color:#003d9b;">
                        {{ $company->industry }}
                    </span>
                @endif
                @if ($company->company_size)
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full" style="background-color:#e1e2e4; color:#526069;">
                        {{ $company->company_size }} empleados
                    </span>
                @endif
                @if ($company->city)
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full flex items-center gap-1" style="background-color:#e1e2e4; color:#526069;">
                        <span class="material-symbols-outlined text-xs">location_on</span>
                        {{ $company->city }}{{ $company->province ? ', '.$company->province : '' }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Descripción --}}
    @if ($company->description)
        <div class="rounded-xl border p-6" style="background-color:#ffffff; border-color:#c3c6d6;">
            <h2 class="text-base font-semibold mb-3" style="color:#191c1e;">Sobre la empresa</h2>
            <p class="text-sm leading-relaxed" style="color:#434654;">{{ $company->description }}</p>
        </div>
    @endif

    {{-- Contacto --}}
    @if ($company->website || $company->email || $company->phone)
        <div class="rounded-xl border p-6" style="background-color:#ffffff; border-color:#c3c6d6;">
            <h2 class="text-base font-semibold mb-4" style="color:#191c1e;">Contacto</h2>
            <div class="flex flex-col gap-3">
                @if ($company->website)
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-xl" style="color:#003d9b;">language</span>
                        <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer" class="text-sm font-semibold" style="color:#003d9b;">
                            {{ $company->website }}
                        </a>
                    </div>
                @endif
                @if ($company->email)
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-xl" style="color:#526069;">mail</span>
                        <span class="text-sm" style="color:#434654;">{{ $company->email }}</span>
                    </div>
                @endif
                @if ($company->phone)
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-xl" style="color:#526069;">phone</span>
                        <span class="text-sm" style="color:#434654;">{{ $company->phone }}</span>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Ofertas activas --}}
    <div class="rounded-xl border p-6" style="background-color:#ffffff; border-color:#c3c6d6;">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-base font-semibold" style="color:#191c1e;">Ofertas activas</h2>
            <span class="text-xs font-semibold px-2 py-0.5 rounded-full" style="background-color:#d3e2ed; color:#003d9b;">
                {{ $jobs->count() }}
            </span>
        </div>

        @forelse ($jobs as $job)
            <a href="{{ route('jobs.show', $job) }}" wire:navigate
               class="flex items-center justify-between gap-3 p-3 rounded-lg border mb-2 last:mb-0 transition-colors hover:bg-[#f3f4f6]"
               style="border-color:#e1e2e4;">
                <div class="min-w-0">
                    <p class="text-sm font-semibold truncate" style="color:#191c1e;">{{ $job->title }}</p>
                    <p class="text-xs mt-0.5" style="color:#737685;">
                        @if ($job->work_modality){{ ['remote'=>'Remoto','on-site'=>'Presencial','hybrid'=>'Híbrido'][$job->work_modality] ?? $job->work_modality }}@endif
                        @if ($job->city) · {{ $job->city }}@endif
                    </p>
                </div>
                <span class="material-symbols-outlined shrink-0" style="color:#003d9b;">chevron_right</span>
            </a>
        @empty
            <p class="text-sm" style="color:#737685;">Esta empresa no tiene ofertas publicadas por el momento.</p>
        @endforelse
    </div>

</div>
