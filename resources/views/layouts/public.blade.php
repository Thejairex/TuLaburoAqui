<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen" style="background-color:#f8f9fb; font-family:'Hanken Grotesk', sans-serif;">

        <header class="sticky top-0 z-10 border-b" style="background-color:#ffffff; border-color:#c3c6d6;">
            <div class="max-w-5xl mx-auto px-6 h-14 flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-sm font-semibold" style="color:#003d9b; text-decoration:none;">
                    TuLaburoAquí
                </a>
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-xs font-semibold px-3 py-1.5 rounded-lg" style="background-color:#003d9b; color:#ffffff; text-decoration:none;">
                            Mi dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-semibold" style="color:#003d9b; text-decoration:none;">Iniciar sesión</a>
                        <a href="{{ route('register') }}" class="text-xs font-semibold px-3 py-1.5 rounded-lg" style="background-color:#003d9b; color:#ffffff; text-decoration:none;">Registrarse</a>
                    @endauth
                </div>
            </div>
        </header>

        <main>
            {{ $slot }}
        </main>

        @fluxScripts
    </body>
</html>
