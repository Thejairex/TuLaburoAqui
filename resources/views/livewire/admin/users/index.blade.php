<div class="max-w-6xl mx-auto px-4 md:px-8 py-8 flex flex-col gap-6">

    <div>
        <a href="{{ route('admin.dashboard') }}" wire:navigate
           class="flex items-center gap-1 text-sm font-semibold text-lm-primary w-fit hover:underline">
            <span class="material-symbols-outlined text-base leading-none">arrow_back</span>
            Volver al panel
        </a>
        <h1 class="text-2xl font-bold text-lm-on-surface mt-1">Usuarios</h1>
    </div>

    {{-- Filtros --}}
    <div class="flex flex-wrap gap-3">
        <input type="text" wire:model.live.debounce="search" placeholder="Buscar por nombre o email..."
               class="flex-1 min-w-[200px] rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface placeholder:text-lm-outline focus:outline-none focus:ring-2 focus:ring-lm-primary/20 focus:border-lm-primary">
        <select wire:model.live="roleFilter"
                class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface focus:outline-none focus:ring-2 focus:ring-lm-primary/20">
            <option value="">Todos los roles</option>
            <option value="candidate">Candidato</option>
            <option value="employer">Empleador</option>
            <option value="admin">Admin</option>
        </select>
        <select wire:model.live="statusFilter"
                class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface focus:outline-none focus:ring-2 focus:ring-lm-primary/20">
            <option value="">Todos los estados</option>
            <option value="active">Activo</option>
            <option value="blocked">Bloqueado</option>
        </select>
    </div>

    {{-- Tabla --}}
    <div class="bg-white rounded-xl border border-lm-outline-variant overflow-hidden">
        <table class="w-full text-sm">
            <thead>
            <tr class="bg-lm-surface-low text-left text-xs font-semibold text-lm-secondary uppercase">
                <th class="px-5 py-3">Usuario</th>
                <th class="px-5 py-3">Rol</th>
                <th class="px-5 py-3">Estado</th>
                <th class="px-5 py-3">Registro</th>
                <th class="px-5 py-3"></th>
            </tr>
            </thead>
            <tbody class="divide-y divide-lm-surface-highest">
            @foreach ($users as $user)
                <tr class="hover:bg-lm-surface-low transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-lm-secondary-container flex items-center justify-center shrink-0">
                                <span class="text-xs font-bold text-lm-primary">{{ $user->initials() }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-lm-on-surface">{{ $user->name }}</p>
                                <p class="text-xs text-lm-outline">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <span @class([
                            'text-[11px] font-bold px-2 py-0.5 rounded-full capitalize',
                            'bg-lm-secondary-container text-lm-primary' => $user->role === 'candidate',
                            'bg-lm-surface-highest text-lm-secondary' => $user->role === 'employer',
                            'bg-blue-50 text-blue-700' => $user->role === 'admin',
                        ])>
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-5 py-3">
                        <span @class([
                            'text-[11px] font-bold px-2 py-0.5 rounded-full',
                            'bg-green-50 text-green-700' => $user->status === 'active',
                            'bg-red-50 text-red-600' => $user->status === 'blocked',
                        ])>
                            {{ $user->status === 'active' ? 'Activo' : 'Bloqueado' }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-lm-outline">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="px-5 py-3 text-right">
                        @if ($user->role !== 'admin')
                            <button wire:click="toggleStatus('{{ $user->id }}')"
                                    wire:confirm="{{ $user->status === 'blocked' ? '¿Desbloquear este usuario?' : '¿Bloquear este usuario?' }}"
                                    @class([
                                        'text-xs font-semibold px-3 py-1.5 rounded-lg transition-colors',
                                        'border border-red-200 text-red-600 hover:bg-red-50' => $user->status === 'active',
                                        'border border-green-200 text-green-700 hover:bg-green-50' => $user->status === 'blocked',
                                    ])>
                                {{ $user->status === 'active' ? 'Bloquear' : 'Desbloquear' }}
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div>{{ $users->links() }}</div>
</div>
