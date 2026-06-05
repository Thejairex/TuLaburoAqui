<div class="max-w-6xl mx-auto px-4 md:px-8 py-8 flex flex-col gap-6">

    <div>
        <a href="{{ route('admin.dashboard') }}" wire:navigate
           class="flex items-center gap-1 text-sm font-semibold text-lm-primary w-fit hover:underline">
            <span class="material-symbols-outlined text-base leading-none">arrow_back</span>
            Volver al panel
        </a>
        <h1 class="text-2xl font-bold text-lm-on-surface mt-1">Empresas</h1>
    </div>

    <div class="flex flex-wrap gap-3">
        <input type="text" wire:model.live.debounce="search" placeholder="Buscar por nombre o email..."
               class="flex-1 min-w-[200px] rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface placeholder:text-lm-outline focus:outline-none focus:ring-2 focus:ring-lm-primary/20 focus:border-lm-primary">
        <select wire:model.live="statusFilter"
                class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface focus:outline-none focus:ring-2 focus:ring-lm-primary/20">
            <option value="">Todos los estados</option>
            <option value="active">Activa</option>
            <option value="blocked">Bloqueada</option>
        </select>
    </div>

    <div class="bg-white rounded-xl border border-lm-outline-variant overflow-hidden">
        <table class="w-full text-sm">
            <thead>
            <tr class="bg-lm-surface-low text-left text-xs font-semibold text-lm-secondary uppercase">
                <th class="px-5 py-3">Empresa</th>
                <th class="px-5 py-3">Industria</th>
                <th class="px-5 py-3">Ofertas</th>
                <th class="px-5 py-3">Estado</th>
                <th class="px-5 py-3"></th>
            </tr>
            </thead>
            <tbody class="divide-y divide-lm-surface-highest">
            @foreach ($companies as $company)
                <tr class="hover:bg-lm-surface-low transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg border border-lm-surface-highest flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-sm text-lm-secondary">business</span>
                            </div>
                            <div>
                                <p class="font-semibold text-lm-on-surface">{{ $company->display_name ?? $company->legal_name }}</p>
                                <p class="text-xs text-lm-outline">{{ $company->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-lm-on-surface-variant">{{ $company->industry ?? '—' }}</td>
                    <td class="px-5 py-3 text-lm-on-surface-variant">{{ $company->job_posts_count }}</td>
                    <td class="px-5 py-3">
                        <span @class([
                            'text-[11px] font-bold px-2 py-0.5 rounded-full',
                            'bg-green-50 text-green-700' => $company->status === 'active',
                            'bg-red-50 text-red-600' => $company->status === 'blocked',
                        ])>
                            {{ $company->status === 'active' ? 'Activa' : 'Bloqueada' }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <button wire:click="toggleStatus('{{ $company->id }}')"
                                wire:confirm="{{ $company->status === 'blocked' ? '¿Desbloquear esta empresa?' : '¿Bloquear esta empresa?' }}"
                                @class([
                                    'text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors',
                                    'border border-red-200 text-red-600 hover:bg-red-50' => $company->status === 'active',
                                    'border border-green-200 text-green-700 hover:bg-green-50' => $company->status === 'blocked',
                                ])>
                            {{ $company->status === 'active' ? 'Bloquear' : 'Desbloquear' }}
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div>{{ $companies->links() }}</div>
</div>
