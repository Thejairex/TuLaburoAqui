<div class="flex flex-col gap-6 max-w-4xl mx-auto px-4 md:px-8 py-8">

    {{-- Encabezado con completitud --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-lm-on-surface">Mi perfil</h1>
            <p class="text-sm mt-0.5 text-lm-outline">Completá tu información profesional para destacar ante las empresas.</p>
        </div>
        <div class="hidden sm:flex flex-col items-end gap-1 min-w-40">
            <span class="text-xs font-semibold text-lm-secondary">Completitud: {{ $completeness }}%</span>
            <div class="w-40 h-2 rounded-full overflow-hidden bg-lm-surface-highest">
                <div class="h-2 rounded-full transition-all"
                     style="width:{{ $completeness }}%; background-color:#003d9b;"></div>
            </div>
        </div>
    </div>

    <form wire:submit="save" class="flex flex-col gap-6">

        {{-- Foto y datos básicos --}}
        <div id="foto-datos" class="bg-white rounded-xl border border-lm-outline-variant px-6 py-6 flex flex-col gap-5">
            <h2 class="text-base font-bold text-lm-on-surface">Foto y datos básicos</h2>

            <div class="flex flex-col md:flex-row gap-6">
                {{-- Avatar --}}
                <div class="flex flex-col items-center gap-3 shrink-0">
                    @php $avatarUrl = auth()->user()->avatarUrl(); @endphp
                    <div class="w-24 h-24 rounded-full overflow-hidden flex items-center justify-center bg-lm-secondary-container">
                        @if ($avatar)
                            <img src="{{ $avatar->temporaryUrl() }}" alt="Preview" class="w-full h-full object-cover">
                        @elseif ($avatarUrl)
                            <img src="{{ $avatarUrl }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined text-4xl leading-none text-lm-secondary">person</span>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <label for="avatar-upload"
                               class="cursor-pointer text-xs font-semibold px-3 py-1.5 rounded-lg border border-lm-primary text-lm-primary hover:bg-lm-secondary-container transition-colors">
                            Cambiar foto
                            <input id="avatar-upload" type="file" wire:model="avatar" accept="image/*" class="hidden">
                        </label>
                        @if ($avatarUrl && ! $avatar)
                            <button type="button" wire:click="deleteAvatar"
                                    class="text-xs font-semibold px-3 py-1.5 rounded-lg border border-lm-outline-variant text-lm-outline hover:bg-lm-surface-low transition-colors">
                                Eliminar
                            </button>
                        @endif
                    </div>
                    @error('avatar')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campos --}}
                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-lm-on-surface-variant">Nombre completo</label>
                        <input type="text" wire:model="name"
                               class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                        @error('name') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-lm-on-surface-variant">Titular profesional</label>
                        <input type="text" wire:model="headline" placeholder="Ej: Backend Developer"
                               class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                        @error('headline') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col gap-1 md:col-span-2">
                        <label class="text-xs font-semibold text-lm-on-surface-variant">Bio</label>
                        <textarea wire:model="bio" rows="3"
                                  placeholder="Contá un poco sobre vos y tu experiencia..."
                                  class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent resize-none"></textarea>
                        @error('bio') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-lm-on-surface-variant">Teléfono</label>
                        <input type="text" wire:model="phone" placeholder="+54 11 1234-5678"
                               class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                        @error('phone') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-lm-on-surface-variant">Fecha de nacimiento</label>
                        <input type="date" wire:model="birth_date"
                               class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                        @error('birth_date') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-lm-on-surface-variant">Ciudad</label>
                        <input type="text" wire:model="city" placeholder="Buenos Aires"
                               class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                        @error('city') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-lm-on-surface-variant">Provincia</label>
                        <input type="text" wire:model="province" placeholder="Buenos Aires"
                               class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                        @error('province') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Disponibilidad y expectativa salarial --}}
        <div id="disponibilidad" class="bg-white rounded-xl border border-lm-outline-variant px-6 py-6 flex flex-col gap-5">
            <h2 class="text-base font-bold text-lm-on-surface">Disponibilidad y expectativa salarial</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-lm-on-surface-variant">Disponibilidad inmediata</label>
                    <select wire:model="available_immediately"
                            class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                        <option value="">Seleccioná...</option>
                        <option value="yes">Sí, disponible ahora</option>
                        <option value="soon">Próximamente (menos de 30 días)</option>
                        <option value="no">No disponible por el momento</option>
                    </select>
                    @error('available_immediately') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-lm-on-surface-variant">Modalidad de trabajo</label>
                    <select wire:model="work_modality"
                            class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                        <option value="">Seleccioná...</option>
                        <option value="remote">Remoto</option>
                        <option value="onsite">Presencial</option>
                        <option value="hybrid">Híbrido</option>
                    </select>
                    @error('work_modality') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-lm-on-surface-variant">Años de experiencia total</label>
                    <input type="number" wire:model="years_experience" min="0" max="60"
                           class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                    @error('years_experience') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-lm-on-surface-variant">Período salarial</label>
                    <select wire:model="salary_period"
                            class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                        <option value="MTH">Mensual</option>
                        <option value="HR">Por hora</option>
                    </select>
                    @error('salary_period') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-lm-on-surface-variant">Salario esperado mínimo</label>
                    <input type="number" wire:model="salary_min" min="0" placeholder="1000"
                           class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                    @error('salary_min') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-lm-on-surface-variant">Salario esperado máximo</label>
                    <input type="number" wire:model="salary_max" min="0" placeholder="3000"
                           class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                    @error('salary_max') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- CV --}}
        <div id="cv" class="bg-white rounded-xl border border-lm-outline-variant px-6 py-6 flex flex-col gap-4">
            <h2 class="text-base font-bold text-lm-on-surface">CV</h2>

            @php $cvMedia = auth()->user()->workerProfile?->getFirstMedia('cv'); @endphp

            @if ($cvMedia)
                <div class="flex items-center gap-3 p-3 rounded-lg border border-lm-outline-variant bg-lm-surface-low">
                    <span class="material-symbols-outlined text-2xl leading-none text-lm-primary">picture_as_pdf</span>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-lm-on-surface">{{ $cvMedia->file_name }}</p>
                        <p class="text-xs text-lm-outline">{{ number_format($cvMedia->size / 1024, 0) }} KB</p>
                    </div>
                    <a href="{{ $cvMedia->getUrl() }}" target="_blank"
                       class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-lm-secondary-container text-lm-primary hover:opacity-80 transition-opacity">
                        Ver
                    </a>
                    <button type="button" wire:click="deleteCv"
                            class="text-xs font-semibold px-3 py-1.5 rounded-lg border border-lm-outline-variant text-lm-outline hover:bg-lm-surface-low transition-colors">
                        Eliminar
                    </button>
                </div>
            @endif

            <div class="flex flex-col gap-1">
                <label class="text-xs font-semibold text-lm-on-surface-variant">
                    {{ $cvMedia ? 'Reemplazar CV' : 'Subir CV' }} (PDF, máx. 10MB)
                </label>
                <input type="file" wire:model="cv" accept=".pdf"
                       class="text-sm text-lm-outline file:mr-3 file:rounded-lg file:border-0 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:cursor-pointer file:bg-lm-secondary-container file:text-lm-primary">
                @error('cv') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Habilidades --}}
        <div id="habilidades" class="bg-white rounded-xl border border-lm-outline-variant px-6 py-6 flex flex-col gap-4">
            <h2 class="text-base font-bold text-lm-on-surface">Habilidades</h2>

            <div class="flex gap-2" x-data="{ skill: '' }">
                <select x-model="skill"
                        class="flex-1 rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
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
                        @click="if (skill) { $wire.addSkill(skill); skill = '' }"
                        class="px-4 py-2 rounded-lg text-sm font-semibold text-white transition-opacity hover:opacity-80"
                        style="background-color:#003d9b;">
                    Agregar
                </button>
            </div>

            @forelse ($selectedSkills as $index => $skill)
                <div class="flex items-center gap-3 p-3 rounded-lg border border-lm-outline-variant bg-lm-surface-low">
                    <span class="flex-1 text-sm font-semibold text-lm-on-surface">{{ $skill['name'] }}</span>

                    <div class="flex items-center gap-2">
                        <label class="text-xs text-lm-outline">Nivel</label>
                        <select wire:model="selectedSkills.{{ $index }}.level"
                                class="rounded-lg border border-lm-outline-variant px-2 py-1 text-xs text-lm-on-surface bg-white">
                            <option value="1">Principiante</option>
                            <option value="2">Intermedio</option>
                            <option value="3">Avanzado</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2">
                        <label class="text-xs text-lm-outline">Años</label>
                        <input type="number" wire:model="selectedSkills.{{ $index }}.experience_years"
                               min="0" max="60" placeholder="—"
                               class="rounded-lg border border-lm-outline-variant px-2 py-1 text-xs w-14 text-center text-lm-on-surface bg-white">
                    </div>

                    <button type="button" wire:click="removeSkill('{{ $skill['skill_id'] }}')"
                            class="rounded-lg p-1 text-lm-outline hover:text-red-600 hover:bg-red-50 transition-colors">
                        <span class="material-symbols-outlined text-base leading-none">close</span>
                    </button>
                </div>
            @empty
                <p class="text-sm text-lm-outline">No agregaste habilidades todavía.</p>
            @endforelse
        </div>

        {{-- Botón guardar --}}
        <div class="flex justify-end pb-6">
            <button type="submit"
                    class="px-6 py-2.5 rounded-lg text-sm font-semibold text-white transition-opacity hover:opacity-80"
                    style="background-color:#003d9b;">
                <span wire:loading.remove wire:target="save">Guardar cambios</span>
                <span wire:loading wire:target="save">Guardando...</span>
            </button>
        </div>

    </form>
</div>
