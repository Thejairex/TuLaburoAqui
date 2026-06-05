<div class="max-w-6xl mx-auto px-4 md:px-8 py-8 flex flex-col gap-6">

    <div>
        <a href="{{ route('admin.dashboard') }}" wire:navigate
           class="flex items-center gap-1 text-sm font-semibold text-lm-primary w-fit hover:underline">
            <span class="material-symbols-outlined text-base leading-none">arrow_back</span>
            Volver al panel
        </a>
        <h1 class="text-2xl font-bold text-lm-on-surface mt-1">Ofertas</h1>
    </div>

    <div class="flex flex-wrap gap-3">
        <input type="text" wire:model.live.debounce="search" placeholder="Buscar por título..."
               class="flex-1 min-w-[200px] rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface placeholder:text-lm-outline focus:outline-none focus:ring-2 focus:ring-lm-primary/20 focus:border-lm-primary">
        <select wire:model.live="statusFilter"
                class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface focus:outline-none focus:ring-2 focus:ring-lm-primary/20">
            <option value="">Todos los estados</option>
            <option value="draft">Borrador</option>
            <option value="published">Publicada</option>
            <option value="paused">Pausada</option>
            <option value="closed">Cerrada</option>
            <option value="expired">Vencida</option>
        </select>
    </div>

    <div class="bg-white rounded-xl border border-lm-outline-variant overflow-hidden">
        <table class="w-full text-sm">
            <thead>
            <tr class="bg-lm-surface-low text-left text-xs font-semibold text-lm-secondary uppercase">
                <th class="px-5 py-3">Título</th>
                <th class="px-5 py-3">Empresa</th>
                <th class="px-5 py-3">Postulaciones</th>
                <th class="px-5 py-3">Estado</th>
                <th class="px-5 py-3"></th>
            </tr>
            </thead>
            <tbody class="divide-y divide-lm-surface-highest">
            @foreach ($jobs as $job)
                @php $color = $job->statusColor(); @endphp
                <tr class="hover:bg-lm-surface-low transition-colors">
                    <td class="px-5 py-3 font-semibold text-lm-on-surface">{{ $job->title }}</td>
                    <td class="px-5 py-3 text-lm-on-surface-variant">{{ $job->company?->display_name ?? $job->company?->legal_name ?? '—' }}</td>
                    <td class="px-5 py-3 text-lm-on-surface-variant">{{ $job->applications_count }}</td>
                    <td class="px-5 py-3">
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded-full"
                              style="background-color:{{ $color['bg'] }}; color:{{ $color['text'] }};">
                            {{ $job->statusLabel() }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        @if ($job->status !== 'closed')
                            <button wire:click="close('{{ $job->id }}')"
                                    wire:confirm="¿Cerrar esta oferta?"
                                    class="text-xs font-semibold px-3 py-1.5 rounded-lg border border-red-200 text-red-600 hover:bg-red-50 transition-colors">
                                Cerrar
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div>{{ $jobs->links() }}</div>
</div>
