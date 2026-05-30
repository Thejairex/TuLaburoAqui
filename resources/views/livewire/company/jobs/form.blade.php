<div class="max-w-4xl mx-auto px-4 md:px-8 py-8 flex flex-col gap-6">

    {{-- Encabezado --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('company.jobs.index') }}" wire:navigate
           class="p-2 rounded-lg text-lm-on-surface-variant hover:bg-lm-surface-low transition-colors">
            <span class="material-symbols-outlined text-xl leading-none">arrow_back</span>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-lm-on-surface">
                {{ $jobPost?->exists ? 'Editar oferta' : 'Nueva oferta' }}
            </h1>
            <p class="text-sm mt-0.5 text-lm-outline">Describí el puesto para atraer a los candidatos adecuados.</p>
        </div>
    </div>

    <form wire:submit="save" class="flex flex-col gap-6">

        {{-- Datos del puesto --}}
        <div class="bg-white rounded-xl border border-lm-outline-variant px-6 py-6 flex flex-col gap-5">
            <h2 class="text-base font-bold text-lm-on-surface">Datos del puesto</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col gap-1 md:col-span-2">
                    <label class="text-xs font-semibold text-lm-on-surface-variant">Título del puesto <span class="text-red-600">*</span></label>
                    <input type="text" wire:model="title" placeholder="Ej: Electricista industrial"
                           class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                    @error('title') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1 md:col-span-2">
                    <label class="text-xs font-semibold text-lm-on-surface-variant">Descripción <span class="text-red-600">*</span></label>
                    <textarea wire:model="description" rows="6" placeholder="Detallá responsabilidades, requisitos y beneficios..."
                              class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent resize-none"></textarea>
                    @error('description') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-lm-on-surface-variant">Categoría / Rubro</label>
                    <input type="text" wire:model="category" placeholder="Ej: Construcción"
                           class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                    @error('category') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-lm-on-surface-variant">Seniority</label>
                    <select wire:model="seniority"
                            class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                        <option value="">Seleccioná...</option>
                        <option value="junior">Junior</option>
                        <option value="mid">Semi Senior</option>
                        <option value="senior">Senior</option>
                        <option value="lead">Lead</option>
                    </select>
                    @error('seniority') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Condiciones --}}
        <div class="bg-white rounded-xl border border-lm-outline-variant px-6 py-6 flex flex-col gap-5">
            <h2 class="text-base font-bold text-lm-on-surface">Condiciones y ubicación</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-lm-on-surface-variant">Tipo de contrato</label>
                    <select wire:model="contract_type"
                            class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                        <option value="">Seleccioná...</option>
                        <option value="full-time">Tiempo completo</option>
                        <option value="part-time">Medio tiempo</option>
                        <option value="contract">Contrato</option>
                        <option value="internship">Pasantía</option>
                        <option value="freelance">Freelance</option>
                    </select>
                    @error('contract_type') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-lm-on-surface-variant">Modalidad</label>
                    <select wire:model="work_modality"
                            class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                        <option value="">Seleccioná...</option>
                        <option value="remote">Remoto</option>
                        <option value="on-site">Presencial</option>
                        <option value="hybrid">Híbrido</option>
                    </select>
                    @error('work_modality') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
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

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-lm-on-surface-variant">Vacantes <span class="text-red-600">*</span></label>
                    <input type="number" wire:model="vacancies" min="1" max="999"
                           class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                    @error('vacancies') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Salario --}}
        <div class="bg-white rounded-xl border border-lm-outline-variant px-6 py-6 flex flex-col gap-5">
            <h2 class="text-base font-bold text-lm-on-surface">Salario</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-lm-on-surface-variant">Mínimo</label>
                    <input type="number" wire:model="salary_min" min="0" placeholder="1000"
                           class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                    @error('salary_min') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-lm-on-surface-variant">Máximo</label>
                    <input type="number" wire:model="salary_max" min="0" placeholder="3000"
                           class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface bg-white focus:outline-none focus:ring-2 focus:ring-lm-primary focus:border-transparent">
                    @error('salary_max') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                </div>

                <label class="flex items-center gap-2 md:col-span-2 cursor-pointer">
                    <input type="checkbox" wire:model="salary_visible" class="rounded border-lm-outline-variant text-lm-primary focus:ring-lm-primary">
                    <span class="text-sm text-lm-on-surface-variant">Mostrar el salario públicamente en la oferta</span>
                </label>
            </div>
        </div>

        {{-- Habilidades --}}
        <div class="bg-white rounded-xl border border-lm-outline-variant px-6 py-6 flex flex-col gap-4">
            <h2 class="text-base font-bold text-lm-on-surface">Habilidades requeridas</h2>

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

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="selectedSkills.{{ $index }}.required"
                               class="rounded border-lm-outline-variant text-lm-primary focus:ring-lm-primary">
                        <span class="text-xs text-lm-outline">Excluyente</span>
                    </label>

                    <button type="button" wire:click="removeSkill('{{ $skill['skill_id'] }}')"
                            class="rounded-lg p-1 text-lm-outline hover:text-red-600 hover:bg-red-50 transition-colors">
                        <span class="material-symbols-outlined text-base leading-none">close</span>
                    </button>
                </div>
            @empty
                <p class="text-sm text-lm-outline">No agregaste habilidades todavía.</p>
            @endforelse
        </div>

        {{-- Acciones --}}
        <div class="flex justify-end gap-3 pb-6">
            <button type="button" wire:click="save('draft')"
                    class="px-5 py-2.5 rounded-lg text-sm font-semibold border border-lm-primary text-lm-primary hover:bg-lm-secondary-container transition-colors">
                <span wire:loading.remove wire:target="save('draft')">Guardar borrador</span>
                <span wire:loading wire:target="save('draft')">Guardando...</span>
            </button>
            <button type="button" wire:click="save('published')"
                    class="px-5 py-2.5 rounded-lg text-sm font-semibold text-white transition-opacity hover:opacity-80"
                    style="background-color:#003d9b;">
                <span wire:loading.remove wire:target="save('published')">Publicar oferta</span>
                <span wire:loading wire:target="save('published')">Publicando...</span>
            </button>
        </div>

    </form>
</div>
