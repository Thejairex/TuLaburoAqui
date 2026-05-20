<x-layouts::auth :title="__('Iniciar sesión') . ' — ' . config('app.name')">
    <div class="w-full max-w-[480px]">

        {{-- Brand --}}
        <div class="text-center mb-10">
            <h1 class="text-[32px] font-bold tracking-tight mb-1" style="color: #003d9b;">
                {{ config('app.name', 'LaborMarket') }}
            </h1>
        </div>

        {{-- Card --}}
        <div class="w-full rounded-lg border p-6 md:p-10 shadow-sm" style="background-color: #ffffff; border-color: #c3c6d6;">

            <div class="text-center mb-8">
                <h2 class="text-xl font-semibold mb-1" style="color: #191c1e;">Bienvenido de vuelta</h2>
                <p class="text-sm" style="color: #434654;">Ingresá tus credenciales para continuar</p>
            </div>

            {{-- Session Status --}}
            <x-auth-session-status class="mb-4 text-sm text-center" :status="session('status')" />

            <form method="POST" action="{{ route('login.store') }}" class="space-y-6">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-bold mb-1" style="color: #191c1e;">
                        Email
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg" style="color: #737685;">mail</span>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="email"
                            placeholder="ejemplo@correo.com"
                            class="w-full pl-10 pr-4 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition-colors @error('email') ring-2 @enderror"
                            style="border-color: {{ $errors->has('email') ? '#ba1a1a' : '#c3c6d6' }}; background-color: #ffffff; color: #191c1e; --tw-ring-color: #003d9b;"
                        >
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs font-semibold" style="color: #ba1a1a;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div>
                    <div class="flex justify-between mb-1">
                        <label for="password" class="text-sm font-bold" style="color: #191c1e;">Contraseña</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" wire:navigate
                               class="text-sm hover:underline" style="color: #003d9b;">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg" style="color: #737685;">lock</span>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full pl-10 pr-12 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition-colors @error('password') ring-2 @enderror"
                            style="border-color: {{ $errors->has('password') ? '#ba1a1a' : '#c3c6d6' }}; background-color: #ffffff; color: #191c1e; --tw-ring-color: #003d9b;"
                        >
                        <button type="button"
                                onclick="togglePassword('password', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2 transition-colors"
                                style="color: #737685;">
                            <span class="material-symbols-outlined text-lg">visibility</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs font-semibold" style="color: #ba1a1a;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="flex items-center gap-2">
                    <input id="remember" name="remember" type="checkbox"
                           class="rounded border" style="border-color: #c3c6d6; accent-color: #003d9b;"
                           {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="text-sm" style="color: #434654;">Recordarme</label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 py-3 px-6 rounded-lg text-sm font-bold transition-opacity hover:opacity-90 active:opacity-80"
                        style="background-color: #003d9b; color: #ffffff;">
                    Iniciar sesión
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>

                {{-- Separador --}}
                <div class="relative flex items-center py-2">
                    <div class="flex-grow border-t" style="border-color: #c3c6d6;"></div>
                    <span class="mx-4 text-xs font-semibold tracking-wider uppercase" style="color: #737685;">o</span>
                    <div class="flex-grow border-t" style="border-color: #c3c6d6;"></div>
                </div>

                {{-- Google --}}
                <button type="button"
                        class="w-full flex items-center justify-center gap-3 py-3 px-6 rounded-lg border text-sm font-bold transition-colors hover:opacity-90"
                        style="background-color: #ffffff; border-color: #c3c6d6; color: #191c1e;">
                    <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Continuar con Google
                </button>
            </form>

            {{-- Footer --}}
            <div class="mt-8 text-center text-sm" style="color: #434654;">
                ¿No tenés cuenta?
                <a href="{{ route('register') }}" wire:navigate
                   class="font-bold hover:underline ml-1" style="color: #003d9b;">
                    Registrate
                </a>
            </div>
        </div>

        <p class="mt-6 text-center text-xs" style="color: #737685;">
            © {{ date('Y') }} {{ config('app.name', 'LaborMarket') }}. Todos los derechos reservados.
        </p>
    </div>

    <script>
        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const icon = btn.querySelector('.material-symbols-outlined');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        }
    </script>
</x-layouts::auth>
