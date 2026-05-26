<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen" style="background-color:#f8f9fb; font-family:'Hanken Grotesk', sans-serif;">

        {{-- Navbar superior --}}
        <header class="sticky top-0 z-10 border-b" style="background-color:#ffffff; border-color:#c3c6d6;">
            <div class="max-w-5xl mx-auto px-6 h-14 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2 text-sm font-semibold" style="color:#003d9b; text-decoration:none;">
                    <span class="material-symbols-outlined text-base">arrow_back</span>
                    Volver al dashboard
                </a>
                <span class="text-sm font-semibold" style="color:#191c1e;">TuLaburoAquí</span>
            </div>
        </header>

        <main>
            {{ $slot }}
        </main>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
