<div class="flex flex-col gap-6 p-6 max-w-4xl mx-auto">

    {{-- Encabezado con completitud --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold" style="color:#191c1e;">Perfil de empresa</h1>
            <p class="text-sm mt-0.5" style="color:#737685;">Completá la información de tu empresa para que los candidatos la conozcan.</p>
        </div>
        <div class="flex flex-col items-end gap-1 min-w-40">
            <span class="text-xs font-semibold" style="color:#526069;">Completitud: {{ $completeness }}%</span>
            <div class="w-40 h-2 rounded-full overflow-hidden" style="background-color:#e1e2e4;">
                <div class="h-2 rounded-full transition-all" style="width:{{ $completeness }}%; background-color:#003d9b;"></div>
            </div>
        </div>
    </div>

    @if ($company)
        <div class="flex items-center gap-3 p-3 rounded-lg text-xs" style="background-color:#d3e2ed; border:1px solid #a8c4de;">
            <span class="material-symbols-outlined text-base" style="color:#003d9b;">link</span>
            <span style="color:#434654;">Perfil público:</span>
            <a href="{{ route('company.show', $company) }}" target="_blank" class="font-semibold" style="color:#003d9b;">
                /empresa/{{ $company->slug }}
            </a>
        </div>
    @endif

    <form wire:submit="save" class="flex flex-col gap-6">

        {{-- Logo e identidad --}}
        <div id="identidad" class="rounded-xl border p-6 flex flex-col gap-5" style="background-color:#ffffff; border-color:#c3c6d6;">
            <h2 class="text-base font-semibold" style="color:#191c1e;">Logo e identidad</h2>

            <div class="flex flex-col md:flex-row gap-6">
                {{-- Logo --}}
                <div class="flex flex-col items-center gap-3 shrink-0">
                    @php $logoUrl = $company?->logoUrl(); @endphp
                    <div class="w-24 h-24 rounded-xl overflow-hidden flex items-center justify-center border" style="background-color:#f3f4f6; border-color:#c3c6d6;">
                        @if ($logo)
                            <img src="{{ $logo->temporaryUrl() }}" alt="Preview" class="w-full h-full object-cover">
                        @elseif ($logoUrl)
                            <img src="{{ $logoUrl }}" alt="Logo" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined text-4xl" style="color:#526069;">business</span>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <label for="logo-upload" class="cursor-pointer text-xs font-semibold px-3 py-1.5 rounded-lg border" style="border-color:#003d9b; color:#003d9b;">
                            Cambiar logo
                            <input id="logo-upload" type="file" wire:model="logo" accept="image/*" class="hidden">
                        </label>
                        @if ($logoUrl && !$logo)
                            <button type="button" wire:click="deleteLogo" class="text-xs font-semibold px-3 py-1.5 rounded-lg border" style="border-color:#c3c6d6; color:#737685;">
                                Eliminar
                            </button>
                        @endif
                    </div>
                    @error('logo')
                        <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campos de identidad --}}
                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1 md:col-span-2">
                        <label class="text-xs font-semibold" style="color:#434654;">Nombre que mostramos <span style="color:#ba1a1a;">*</span></label>
                        <input type="text" wire:model="display_name" placeholder="Ej: Acme Argentina" class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                        @error('display_name') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col gap-1 md:col-span-2">
                        <label class="text-xs font-semibold" style="color:#434654;">Razón social <span style="color:#ba1a1a;">*</span></label>
                        <input type="text" wire:model="legal_name" placeholder="Ej: Acme S.R.L." class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                        @error('legal_name') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold" style="color:#434654;">Industria / Rubro</label>
                        <input type="text" wire:model="industry" placeholder="Ej: Tecnología" class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                        @error('industry') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold" style="color:#434654;">Tamaño de empresa</label>
                        <select wire:model="company_size" class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                            <option value="">Seleccioná...</option>
                            <option value="1-10">1–10 empleados</option>
                            <option value="11-50">11–50 empleados</option>
                            <option value="51-200">51–200 empleados</option>
                            <option value="201-500">201–500 empleados</option>
                            <option value="500+">Más de 500</option>
                        </select>
                        @error('company_size') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Descripción --}}
        <div id="descripcion" class="rounded-xl border p-6 flex flex-col gap-4" style="background-color:#ffffff; border-color:#c3c6d6;">
            <h2 class="text-base font-semibold" style="color:#191c1e;">Descripción</h2>
            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold" style="color:#434654;">Sobre la empresa</label>
                <textarea wire:model="description" rows="4" placeholder="Contá qué hace la empresa, su cultura y por qué vale la pena trabajar ahí..." class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700 resize-none" style="border-color:#c3c6d6; background:#fff; color:#191c1e;"></textarea>
                @error('description') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Contacto y ubicación --}}
        <div id="contacto" class="rounded-xl border p-6 flex flex-col gap-5" style="background-color:#ffffff; border-color:#c3c6d6;">
            <h2 class="text-base font-semibold" style="color:#191c1e;">Contacto y ubicación</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col gap-1 md:col-span-2">
                    <label class="text-xs font-semibold" style="color:#434654;">Sitio web</label>
                    <input type="url" wire:model="website" placeholder="https://empresa.com" class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                    @error('website') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold" style="color:#434654;">Email de contacto</label>
                    <input type="email" wire:model="email" placeholder="contacto@empresa.com" class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                    @error('email') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold" style="color:#434654;">Teléfono</label>
                    <input type="text" wire:model="phone" placeholder="+54 11 1234-5678" class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                    @error('phone') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold" style="color:#434654;">Ciudad</label>
                    <input type="text" wire:model="city" placeholder="Buenos Aires" class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                    @error('city') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold" style="color:#434654;">Provincia</label>
                    <input type="text" wire:model="province" placeholder="Buenos Aires" class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                    @error('province') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Guardar --}}
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2.5 rounded-lg text-sm font-semibold" style="background-color:#003d9b; color:#ffffff;">
                <span wire:loading.remove wire:target="save">Guardar cambios</span>
                <span wire:loading wire:target="save">Guardando...</span>
            </button>
        </div>

    </form>
</div>
