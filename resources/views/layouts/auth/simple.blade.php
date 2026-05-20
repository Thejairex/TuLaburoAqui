<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'LaborMarket') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    @include('partials.head')
    <style>
        body { font-family: 'Hanken Grotesk', ui-sans-serif, system-ui, sans-serif !important; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
    </style>
</head>
<body class="min-h-screen antialiased" style="background-color: #f8f9fb; color: #191c1e;">

    <header class="w-full sticky top-0 z-50 border-b" style="background-color: #ffffff; border-color: #c3c6d6;">
        <div class="flex justify-between items-center px-8 h-16 w-full max-w-[1200px] mx-auto">
            <a href="{{ route('home') }}" wire:navigate
               class="text-[28px] font-bold tracking-tight" style="color: #003d9b;">
                {{ config('app.name', 'LaborMarket') }}
            </a>
            <div class="flex gap-3 items-center">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" wire:navigate
                       class="px-5 py-2 text-xs font-semibold tracking-wider uppercase transition-colors rounded"
                       style="color: #003d9b;">
                        Iniciar sesión
                    </a>
                @endif
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" wire:navigate
                       class="px-5 py-2 text-xs font-semibold tracking-wider uppercase rounded-lg transition-opacity"
                       style="background-color: #003d9b; color: #ffffff;">
                        Registrarse
                    </a>
                @endif
            </div>
        </div>
    </header>

    <main class="flex min-h-[calc(100vh-4rem)] flex-col items-center justify-center py-10 px-4 md:px-8">
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
