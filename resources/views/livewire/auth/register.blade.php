<div class="w-full max-w-[640px]">

    {{-- Brand --}}
    <div class="text-center mb-8">
        <h1 class="text-[32px] font-bold tracking-tight mb-1" style="color: #003d9b;">
            {{ config('app.name', 'LaborMarket') }}
        </h1>
    </div>

    {{-- Barra de progreso --}}
    <div class="mb-8">
        <div class="flex justify-between mb-2">
            <span class="text-xs font-semibold tracking-wider uppercase" style="color: #003d9b;">
                {{ $step === 1 ? 'Paso 1: Elegí tu perfil' : ($role === 'candidate' ? 'Paso 2: Tus datos' : 'Paso 2: Datos de la empresa') }}
            </span>
            <span class="text-xs font-semibold" style="color: #526069;">{{ $step === 1 ? '50%' : '100%' }}</span>
        </div>
        <div class="w-full h-1.5 rounded-full overflow-hidden" style="background-color: #e1e2e4;">
            <div class="h-full rounded-full transition-all duration-500"
                 style="background-color: #003d9b; width: {{ $step === 1 ? '50%' : '100%' }};"></div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- PASO 1 — Selector de rol --}}
    {{-- ============================================================ --}}
    @if ($step === 1)
        <div class="w-full rounded-lg border p-6 md:p-10 shadow-sm" style="background-color: #ffffff; border-color: #c3c6d6;">

            <div class="text-center mb-8">
                <h2 class="text-xl font-semibold mb-1" style="color: #191c1e;">Bienvenido a {{ config('app.name', 'LaborMarket') }}</h2>
                <p class="text-sm" style="color: #434654;">Para comenzar, contanos qué estás buscando hoy.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Candidato --}}
                <button wire:click="selectRole('candidate')"
                        class="group flex flex-col items-center text-center p-8 rounded-xl border transition-all hover:border-[#003d9b] hover:shadow-md"
                        style="border-color: #c3c6d6; background-color: #ffffff;">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 transition-colors group-hover:bg-[#dae2ff]"
                         style="background-color: #d3e2ed;">
                        <span class="material-symbols-outlined text-[32px]" style="color: #003d9b;">person_search</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2" style="color: #191c1e;">Buscar trabajo</h3>
                    <p class="text-sm" style="color: #526069;">
                        Encontrá vacantes que se ajusten a tu perfil y disponibilidad.
                    </p>
                </button>

                {{-- Empleador --}}
                <button wire:click="selectRole('employer')"
                        class="group flex flex-col items-center text-center p-8 rounded-xl border transition-all hover:border-[#003d9b] hover:shadow-md"
                        style="border-color: #c3c6d6; background-color: #ffffff;">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 transition-colors group-hover:bg-[#dae2ff]"
                         style="background-color: #d3e2ed;">
                        <span class="material-symbols-outlined text-[32px]" style="color: #003d9b;">business_center</span>
                    </div>
                    <h3 class="text-lg font-semibold mb-2" style="color: #191c1e;">Publicar ofertas</h3>
                    <p class="text-sm" style="color: #526069;">
                        Publicá ofertas y conectá con los mejores talentos operativos.
                    </p>
                </button>

            </div>

            <div class="mt-8 text-center text-sm" style="color: #434654;">
                ¿Ya tenés cuenta?
                <a href="{{ route('login') }}" wire:navigate class="font-bold hover:underline ml-1" style="color: #003d9b;">
                    Iniciá sesión
                </a>
            </div>
        </div>

    {{-- ============================================================ --}}
    {{-- PASO 2A — Formulario candidato --}}
    {{-- ============================================================ --}}
    @elseif ($role === 'candidate')
        <div class="w-full rounded-lg border p-6 md:p-10 shadow-sm" style="background-color: #ffffff; border-color: #c3c6d6;">

            <div class="flex items-center gap-3 mb-8">
                <button wire:click="back" class="p-2 rounded-lg transition-colors hover:bg-[#f3f4f6]" style="color: #526069;">
                    <span class="material-symbols-outlined text-xl">arrow_back</span>
                </button>
                <div>
                    <h2 class="text-xl font-semibold" style="color: #191c1e;">Tus datos personales</h2>
                    <p class="text-sm" style="color: #434654;">Creá tu cuenta como candidato</p>
                </div>
            </div>

            <x-auth-session-status class="mb-4 text-sm text-center" :status="session('status')" />

            <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="role" value="candidate">

                {{-- Nombre --}}
                <div>
                    <label for="name" class="block text-sm font-bold mb-1" style="color: #191c1e;">Nombre completo</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg" style="color: #737685;">person</span>
                        <input id="name" name="name" type="text"
                               value="{{ old('name') }}"
                               required autofocus autocomplete="name"
                               placeholder="Tu nombre completo"
                               class="w-full pl-10 pr-4 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition-colors"
                               style="border-color: {{ $errors->has('name') ? '#ba1a1a' : '#c3c6d6' }}; background-color: #ffffff; color: #191c1e;">
                    </div>
                    @error('name') <p class="mt-1 text-xs font-semibold" style="color: #ba1a1a;">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-bold mb-1" style="color: #191c1e;">Email</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg" style="color: #737685;">mail</span>
                        <input id="email" name="email" type="email"
                               value="{{ old('email') }}"
                               required autocomplete="email"
                               placeholder="ejemplo@correo.com"
                               class="w-full pl-10 pr-4 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition-colors"
                               style="border-color: {{ $errors->has('email') ? '#ba1a1a' : '#c3c6d6' }}; background-color: #ffffff; color: #191c1e;">
                    </div>
                    @error('email') <p class="mt-1 text-xs font-semibold" style="color: #ba1a1a;">{{ $message }}</p> @enderror
                </div>

                {{-- Contraseña --}}
                <div>
                    <label for="password" class="block text-sm font-bold mb-1" style="color: #191c1e;">Contraseña</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg" style="color: #737685;">lock</span>
                        <input id="password" name="password" type="password"
                               required autocomplete="new-password"
                               placeholder="Mínimo 8 caracteres"
                               oninput="checkPasswordStrength(this.value)"
                               class="w-full pl-10 pr-12 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition-colors"
                               style="border-color: {{ $errors->has('password') ? '#ba1a1a' : '#c3c6d6' }}; background-color: #ffffff; color: #191c1e;">
                        <button type="button" onclick="togglePassword('password', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2" style="color: #737685;">
                            <span class="material-symbols-outlined text-lg">visibility</span>
                        </button>
                    </div>
                    <div class="mt-2 flex gap-1">
                        <div class="h-1 flex-1 rounded-full transition-colors" id="s1" style="background-color: #e1e2e4;"></div>
                        <div class="h-1 flex-1 rounded-full transition-colors" id="s2" style="background-color: #e1e2e4;"></div>
                        <div class="h-1 flex-1 rounded-full transition-colors" id="s3" style="background-color: #e1e2e4;"></div>
                        <div class="h-1 flex-1 rounded-full transition-colors" id="s4" style="background-color: #e1e2e4;"></div>
                    </div>
                    @error('password') <p class="mt-1 text-xs font-semibold" style="color: #ba1a1a;">{{ $message }}</p> @enderror
                </div>

                {{-- Confirmar contraseña --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold mb-1" style="color: #191c1e;">Confirmar contraseña</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg" style="color: #737685;">lock_open</span>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                               required autocomplete="new-password"
                               placeholder="Repetí tu contraseña"
                               class="w-full pl-10 pr-12 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition-colors"
                               style="border-color: #c3c6d6; background-color: #ffffff; color: #191c1e;">
                        <button type="button" onclick="togglePassword('password_confirmation', this)"
                                class="absolute right-3 top-1/2 -translate-y-1/2" style="color: #737685;">
                            <span class="material-symbols-outlined text-lg">visibility</span>
                        </button>
                    </div>
                </div>

                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 py-3 px-6 rounded-lg text-sm font-bold transition-opacity hover:opacity-90 mt-2"
                        style="background-color: #003d9b; color: #ffffff;">
                    Crear cuenta
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
            </form>
        </div>

    {{-- ============================================================ --}}
    {{-- PASO 2B — Formulario empleador --}}
    {{-- ============================================================ --}}
    @elseif ($role === 'employer')
        <div class="w-full rounded-lg border p-6 md:p-10 shadow-sm" style="background-color: #ffffff; border-color: #c3c6d6;">

            <div class="flex items-center gap-3 mb-8">
                <button wire:click="back" class="p-2 rounded-lg transition-colors hover:bg-[#f3f4f6]" style="color: #526069;">
                    <span class="material-symbols-outlined text-xl">arrow_back</span>
                </button>
                <div>
                    <h2 class="text-xl font-semibold" style="color: #191c1e;">Crear cuenta empleadora</h2>
                    <p class="text-sm" style="color: #434654;">Tus datos personales y los de tu empresa</p>
                </div>
            </div>

            <x-auth-session-status class="mb-4 text-sm text-center" :status="session('status')" />

            <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="role" value="employer">

                {{-- Sección: datos personales --}}
                <div class="pb-5 border-b" style="border-color: #e1e2e4;">
                    <p class="text-xs font-semibold tracking-wider uppercase mb-4" style="color: #737685;">
                        Datos personales
                    </p>
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-bold mb-1" style="color: #191c1e;">Nombre completo</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg" style="color: #737685;">person</span>
                                <input id="name" name="name" type="text"
                                       value="{{ old('name') }}"
                                       required autofocus autocomplete="name"
                                       placeholder="Tu nombre completo"
                                       class="w-full pl-10 pr-4 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition-colors"
                                       style="border-color: {{ $errors->has('name') ? '#ba1a1a' : '#c3c6d6' }}; background-color: #ffffff; color: #191c1e;">
                            </div>
                            @error('name') <p class="mt-1 text-xs font-semibold" style="color: #ba1a1a;">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-bold mb-1" style="color: #191c1e;">Email</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg" style="color: #737685;">mail</span>
                                <input id="email" name="email" type="email"
                                       value="{{ old('email') }}"
                                       required autocomplete="email"
                                       placeholder="ejemplo@empresa.com"
                                       class="w-full pl-10 pr-4 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition-colors"
                                       style="border-color: {{ $errors->has('email') ? '#ba1a1a' : '#c3c6d6' }}; background-color: #ffffff; color: #191c1e;">
                            </div>
                            @error('email') <p class="mt-1 text-xs font-semibold" style="color: #ba1a1a;">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-bold mb-1" style="color: #191c1e;">Contraseña</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg" style="color: #737685;">lock</span>
                                    <input id="password" name="password" type="password"
                                           required autocomplete="new-password"
                                           placeholder="Mínimo 8 caracteres"
                                           class="w-full pl-10 pr-12 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition-colors"
                                           style="border-color: {{ $errors->has('password') ? '#ba1a1a' : '#c3c6d6' }}; background-color: #ffffff; color: #191c1e;">
                                    <button type="button" onclick="togglePassword('password', this)"
                                            class="absolute right-3 top-1/2 -translate-y-1/2" style="color: #737685;">
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                    </button>
                                </div>
                                @error('password') <p class="mt-1 text-xs font-semibold" style="color: #ba1a1a;">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-bold mb-1" style="color: #191c1e;">Confirmar contraseña</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg" style="color: #737685;">lock_open</span>
                                    <input id="password_confirmation" name="password_confirmation" type="password"
                                           required autocomplete="new-password"
                                           placeholder="Repetí tu contraseña"
                                           class="w-full pl-10 pr-12 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition-colors"
                                           style="border-color: #c3c6d6; background-color: #ffffff; color: #191c1e;">
                                    <button type="button" onclick="togglePassword('password_confirmation', this)"
                                            class="absolute right-3 top-1/2 -translate-y-1/2" style="color: #737685;">
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Sección: datos de la empresa --}}
                <div class="pt-1">
                    <p class="text-xs font-semibold tracking-wider uppercase mb-4" style="color: #737685;">
                        Datos de la empresa
                    </p>
                    <div class="space-y-4">
                        <div>
                            <label for="company_legal_name" class="block text-sm font-bold mb-1" style="color: #191c1e;">Razón social</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg" style="color: #737685;">business</span>
                                <input id="company_legal_name" name="company_legal_name" type="text"
                                       value="{{ old('company_legal_name') }}"
                                       required
                                       placeholder="Nombre legal de la empresa"
                                       class="w-full pl-10 pr-4 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition-colors"
                                       style="border-color: {{ $errors->has('company_legal_name') ? '#ba1a1a' : '#c3c6d6' }}; background-color: #ffffff; color: #191c1e;">
                            </div>
                            @error('company_legal_name') <p class="mt-1 text-xs font-semibold" style="color: #ba1a1a;">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="company_display_name" class="block text-sm font-bold mb-1" style="color: #191c1e;">
                                Nombre comercial <span class="font-normal" style="color: #737685;">(opcional)</span>
                            </label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg" style="color: #737685;">storefront</span>
                                <input id="company_display_name" name="company_display_name" type="text"
                                       value="{{ old('company_display_name') }}"
                                       placeholder="Nombre que verán los candidatos"
                                       class="w-full pl-10 pr-4 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition-colors"
                                       style="border-color: #c3c6d6; background-color: #ffffff; color: #191c1e;">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="company_industry" class="block text-sm font-bold mb-1" style="color: #191c1e;">Industria / Sector</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg" style="color: #737685;">category</span>
                                    <select id="company_industry" name="company_industry"
                                            class="w-full pl-10 pr-4 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition-colors appearance-none"
                                            style="border-color: #c3c6d6; background-color: #ffffff; color: #191c1e;">
                                        <option value="">Seleccioná un sector</option>
                                        <option value="logistics" {{ old('company_industry') === 'logistics' ? 'selected' : '' }}>Logística y Transporte</option>
                                        <option value="retail" {{ old('company_industry') === 'retail' ? 'selected' : '' }}>Retail y Comercio</option>
                                        <option value="construction" {{ old('company_industry') === 'construction' ? 'selected' : '' }}>Construcción</option>
                                        <option value="manufacturing" {{ old('company_industry') === 'manufacturing' ? 'selected' : '' }}>Manufactura</option>
                                        <option value="hospitality" {{ old('company_industry') === 'hospitality' ? 'selected' : '' }}>Hospitalidad y Turismo</option>
                                        <option value="cleaning" {{ old('company_industry') === 'cleaning' ? 'selected' : '' }}>Limpieza y Mantenimiento</option>
                                        <option value="security" {{ old('company_industry') === 'security' ? 'selected' : '' }}>Seguridad</option>
                                        <option value="other" {{ old('company_industry') === 'other' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="company_size" class="block text-sm font-bold mb-1" style="color: #191c1e;">Tamaño de la empresa</label>
                                <div class="relative">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg" style="color: #737685;">groups</span>
                                    <select id="company_size" name="company_size"
                                            class="w-full pl-10 pr-4 py-3 rounded-lg border text-sm focus:outline-none focus:ring-2 transition-colors appearance-none"
                                            style="border-color: #c3c6d6; background-color: #ffffff; color: #191c1e;">
                                        <option value="">Cantidad de empleados</option>
                                        <option value="1-10" {{ old('company_size') === '1-10' ? 'selected' : '' }}>1 – 10 empleados</option>
                                        <option value="11-50" {{ old('company_size') === '11-50' ? 'selected' : '' }}>11 – 50 empleados</option>
                                        <option value="51-200" {{ old('company_size') === '51-200' ? 'selected' : '' }}>51 – 200 empleados</option>
                                        <option value="201-500" {{ old('company_size') === '201-500' ? 'selected' : '' }}>201 – 500 empleados</option>
                                        <option value="500+" {{ old('company_size') === '500+' ? 'selected' : '' }}>Más de 500 empleados</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 py-3 px-6 rounded-lg text-sm font-bold transition-opacity hover:opacity-90 mt-2"
                        style="background-color: #003d9b; color: #ffffff;">
                    Crear cuenta y empresa
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
            </form>
        </div>
    @endif

    <p class="mt-6 text-center text-xs" style="color: #737685;">
        © {{ date('Y') }} {{ config('app.name', 'LaborMarket') }}. Todos los derechos reservados.
    </p>
</div>

<script>
    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('.material-symbols-outlined');
        input.type = input.type === 'password' ? 'text' : 'password';
        icon.textContent = input.type === 'password' ? 'visibility' : 'visibility_off';
    }

    function checkPasswordStrength(value) {
        const bars = ['s1','s2','s3','s4'].map(id => document.getElementById(id));
        if (!bars[0]) return;
        const colors = ['#ba1a1a', '#f8b803', '#0052cc', '#00897b'];
        let score = 0;
        if (value.length >= 8) score++;
        if (/[A-Z]/.test(value)) score++;
        if (/[0-9]/.test(value)) score++;
        if (/[^A-Za-z0-9]/.test(value)) score++;
        bars.forEach((bar, i) => {
            bar.style.backgroundColor = i < score ? colors[score - 1] : '#e1e2e4';
        });
    }
</script>
