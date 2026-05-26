<div class="flex flex-col gap-6 p-6 max-w-4xl mx-auto">

        {{-- Encabezado con completitud --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold" style="color:#191c1e;">Mi perfil</h1>
                <p class="text-sm mt-0.5" style="color:#737685;">Completá tu información profesional para destacar ante las empresas.</p>
            </div>
            <div class="flex flex-col items-end gap-1 min-w-40">
                <span class="text-xs font-semibold" style="color:#526069;">Completitud: {{ $completeness }}%</span>
                <div class="w-40 h-2 rounded-full overflow-hidden" style="background-color:#e1e2e4;">
                    <div class="h-2 rounded-full transition-all" style="width:{{ $completeness }}%; background-color:#003d9b;"></div>
                </div>
            </div>
        </div>

        <form wire:submit="save" class="flex flex-col gap-6">

            {{-- Foto y datos básicos --}}
            <div class="rounded-xl border p-6 flex flex-col gap-5" style="background-color:#ffffff; border-color:#c3c6d6;">
                <h2 class="text-base font-semibold" style="color:#191c1e;">Foto y datos básicos</h2>

                <div class="flex flex-col md:flex-row gap-6">
                    {{-- Avatar --}}
                    <div class="flex flex-col items-center gap-3 shrink-0">
                        @php $avatarUrl = auth()->user()->avatarUrl(); @endphp
                        <div class="w-24 h-24 rounded-full overflow-hidden flex items-center justify-center" style="background-color:#d3e2ed;">
                            @if ($avatar)
                                <img src="{{ $avatar->temporaryUrl() }}" alt="Preview" class="w-full h-full object-cover">
                            @elseif ($avatarUrl)
                                <img src="{{ $avatarUrl }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                <span class="material-symbols-outlined text-4xl" style="color:#526069;">person</span>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <label for="avatar-upload" class="cursor-pointer text-xs font-semibold px-3 py-1.5 rounded-lg border" style="border-color:#003d9b; color:#003d9b;">
                                Cambiar foto
                                <input id="avatar-upload" type="file" wire:model="avatar" accept="image/*" class="hidden">
                            </label>
                            @if ($avatarUrl && !$avatar)
                                <button type="button" wire:click="deleteAvatar" class="text-xs font-semibold px-3 py-1.5 rounded-lg border" style="border-color:#c3c6d6; color:#737685;">
                                    Eliminar
                                </button>
                            @endif
                        </div>
                        @error('avatar')
                            <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Campos --}}
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-semibold" style="color:#434654;">Nombre completo</label>
                            <input type="text" wire:model="name" class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                            @error('name') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-semibold" style="color:#434654;">Titular profesional</label>
                            <input type="text" wire:model="headline" placeholder="Ej: Backend Developer" class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                            @error('headline') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex flex-col gap-1 md:col-span-2">
                            <label class="text-xs font-semibold" style="color:#434654;">Bio</label>
                            <textarea wire:model="bio" rows="3" placeholder="Contá un poco sobre vos y tu experiencia..." class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700 resize-none" style="border-color:#c3c6d6; background:#fff; color:#191c1e;"></textarea>
                            @error('bio') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-semibold" style="color:#434654;">Teléfono</label>
                            <input type="text" wire:model="phone" placeholder="+54 11 1234-5678" class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                            @error('phone') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-semibold" style="color:#434654;">Fecha de nacimiento</label>
                            <input type="date" wire:model="birth_date" class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                            @error('birth_date') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
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
            </div>

            {{-- Disponibilidad y expectativa salarial --}}
            <div class="rounded-xl border p-6 flex flex-col gap-5" style="background-color:#ffffff; border-color:#c3c6d6;">
                <h2 class="text-base font-semibold" style="color:#191c1e;">Disponibilidad y expectativa salarial</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold" style="color:#434654;">Disponibilidad inmediata</label>
                        <select wire:model="available_immediately" class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                            <option value="">Seleccioná...</option>
                            <option value="yes">Sí, disponible ahora</option>
                            <option value="soon">Próximamente (menos de 30 días)</option>
                            <option value="no">No disponible por el momento</option>
                        </select>
                        @error('available_immediately') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold" style="color:#434654;">Modalidad de trabajo</label>
                        <select wire:model="work_modality" class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                            <option value="">Seleccioná...</option>
                            <option value="remote">Remoto</option>
                            <option value="onsite">Presencial</option>
                            <option value="hybrid">Híbrido</option>
                        </select>
                        @error('work_modality') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold" style="color:#434654;">Años de experiencia total</label>
                        <input type="number" wire:model="years_experience" min="0" max="60" class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                        @error('years_experience') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold" style="color:#434654;">Período salarial</label>
                        <select wire:model="salary_period" class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                            <option value="MTH">Mensual</option>
                            <option value="HR">Por hora</option>
                        </select>
                        @error('salary_period') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold" style="color:#434654;">Salario esperado mínimo</label>
                        <input type="number" wire:model="salary_min" min="0" placeholder="1000" class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                        @error('salary_min') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold" style="color:#434654;">Salario esperado máximo</label>
                        <input type="number" wire:model="salary_max" min="0" placeholder="3000" class="rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                        @error('salary_max') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- CV --}}
            <div class="rounded-xl border p-6 flex flex-col gap-4" style="background-color:#ffffff; border-color:#c3c6d6;">
                <h2 class="text-base font-semibold" style="color:#191c1e;">CV</h2>

                @php $cvMedia = auth()->user()->workerProfile?->getFirstMedia('cv'); @endphp

                @if ($cvMedia)
                    <div class="flex items-center gap-3 p-3 rounded-lg" style="background-color:#f3f4f6; border:1px solid #c3c6d6;">
                        <span class="material-symbols-outlined text-2xl" style="color:#003d9b;">picture_as_pdf</span>
                        <div class="flex-1">
                            <p class="text-sm font-semibold" style="color:#191c1e;">{{ $cvMedia->file_name }}</p>
                            <p class="text-xs" style="color:#737685;">{{ number_format($cvMedia->size / 1024, 0) }} KB</p>
                        </div>
                        <a href="{{ $cvMedia->getUrl() }}" target="_blank" class="text-xs font-semibold px-3 py-1.5 rounded-lg" style="background-color:#d3e2ed; color:#003d9b;">
                            Ver
                        </a>
                        <button type="button" wire:click="deleteCv" class="text-xs font-semibold px-3 py-1.5 rounded-lg border" style="border-color:#c3c6d6; color:#737685;">
                            Eliminar
                        </button>
                    </div>
                @endif

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold" style="color:#434654;">{{ $cvMedia ? 'Reemplazar CV' : 'Subir CV' }} (PDF, máx. 10MB)</label>
                    <input type="file" wire:model="cv" accept=".pdf"
                        class="text-sm text-gray-600 file:mr-3 file:rounded-lg file:border-0 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:cursor-pointer"
                        style="file:background-color:#d3e2ed; file:color:#003d9b;">
                    @error('cv') <p class="text-xs" style="color:#ba1a1a;">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Habilidades --}}
            <div class="rounded-xl border p-6 flex flex-col gap-4" style="background-color:#ffffff; border-color:#c3c6d6;">
                <h2 class="text-base font-semibold" style="color:#191c1e;">Habilidades</h2>

                <div class="flex gap-2">
                    <select id="skill-selector" class="flex-1 rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                        <option value="">Buscar y agregar habilidad...</option>
                        @foreach (collect($availableSkills)->groupBy('category') as $category => $skills)
                            <optgroup label="{{ ucfirst($category) }}">
                                @foreach ($skills as $skill)
                                    <option value="{{ $skill['id'] }}">{{ $skill['name'] }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <button type="button"
                        onclick="const sel = document.getElementById('skill-selector'); if(sel.value) { $wire.addSkill(sel.value); sel.value=''; }"
                        class="px-4 py-2 rounded-lg text-sm font-semibold" style="background-color:#003d9b; color:#ffffff;">
                        Agregar
                    </button>
                </div>

                @forelse ($selectedSkills as $index => $skill)
                    <div class="flex items-center gap-3 p-3 rounded-lg" style="background-color:#f3f4f6; border:1px solid #c3c6d6;">
                        <span class="flex-1 text-sm font-semibold" style="color:#191c1e;">{{ $skill['name'] }}</span>

                        <div class="flex items-center gap-2">
                            <label class="text-xs" style="color:#737685;">Nivel</label>
                            <select wire:model="selectedSkills.{{ $index }}.level" class="rounded-lg border px-2 py-1 text-xs" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                                <option value="1">Principiante</option>
                                <option value="2">Intermedio</option>
                                <option value="3">Avanzado</option>
                            </select>
                        </div>

                        <div class="flex items-center gap-2">
                            <label class="text-xs" style="color:#737685;">Años</label>
                            <input type="number" wire:model="selectedSkills.{{ $index }}.experience_years"
                                min="0" max="60" placeholder="—"
                                class="rounded-lg border px-2 py-1 text-xs w-14 text-center" style="border-color:#c3c6d6; background:#fff; color:#191c1e;">
                        </div>

                        <button type="button" wire:click="removeSkill('{{ $skill['skill_id'] }}')"
                            class="rounded-lg p-1 hover:opacity-70" style="color:#737685;">
                            <span class="material-symbols-outlined text-base">close</span>
                        </button>
                    </div>
                @empty
                    <p class="text-sm" style="color:#737685;">No agregaste habilidades todavía.</p>
                @endforelse
            </div>

            {{-- Botón guardar --}}
            <div class="flex justify-end pb-6">
                <button type="submit" class="px-6 py-2.5 rounded-lg text-sm font-semibold" style="background-color:#003d9b; color:#ffffff;">
                    <span wire:loading.remove wire:target="save">Guardar cambios</span>
                    <span wire:loading wire:target="save">Guardando...</span>
                </button>
            </div>

        </form>
</div>
