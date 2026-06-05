<div class="max-w-6xl mx-auto px-4 md:px-8 py-8 flex flex-col gap-6">

    <div>
        <a href="{{ route('admin.dashboard') }}" wire:navigate
           class="flex items-center gap-1 text-sm font-semibold text-lm-primary w-fit hover:underline">
            <span class="material-symbols-outlined text-base leading-none">arrow_back</span>
            Volver al panel
        </a>
        <h1 class="text-2xl font-bold text-lm-on-surface mt-1">Calificaciones</h1>
    </div>

    <div class="flex gap-3">
        <select wire:model.live="visibilityFilter"
                class="rounded-lg border border-lm-outline-variant px-3 py-2 text-sm text-lm-on-surface focus:outline-none focus:ring-2 focus:ring-lm-primary/20">
            <option value="">Todas</option>
            <option value="visible">Visibles</option>
            <option value="hidden">Ocultas</option>
        </select>
    </div>

    <div class="bg-white rounded-xl border border-lm-outline-variant overflow-hidden">
        <table class="w-full text-sm">
            <thead>
            <tr class="bg-lm-surface-low text-left text-xs font-semibold text-lm-secondary uppercase">
                <th class="px-5 py-3">De</th>
                <th class="px-5 py-3">Para</th>
                <th class="px-5 py-3">Oferta</th>
                <th class="px-5 py-3">Rating</th>
                <th class="px-5 py-3">Visibilidad</th>
                <th class="px-5 py-3"></th>
            </tr>
            </thead>
            <tbody class="divide-y divide-lm-surface-highest">
            @foreach ($reviews as $review)
                <tr class="hover:bg-lm-surface-low transition-colors">
                    <td class="px-5 py-3 font-semibold text-lm-on-surface">{{ $review->reviewer->name }}</td>
                    <td class="px-5 py-3 text-lm-on-surface-variant">{{ $review->reviewed->name }}</td>
                    <td class="px-5 py-3 text-lm-on-surface-variant">{{ $review->jobApplication?->jobPost?->title ?? '—' }}</td>
                    <td class="px-5 py-3 text-lm-on-surface-variant">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</td>
                    <td class="px-5 py-3">
                        <span @class([
                            'text-[11px] font-bold px-2 py-0.5 rounded-full',
                            'bg-green-50 text-green-700' => $review->is_visible,
                            'bg-lm-surface-highest text-lm-secondary' => ! $review->is_visible,
                        ])>
                            {{ $review->is_visible ? 'Visible' : 'Oculta' }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <button wire:click="toggleVisibility('{{ $review->id }}')"
                                class="text-xs font-semibold px-3 py-1.5 rounded-lg border border-lm-outline-variant text-lm-on-surface-variant hover:bg-lm-surface-low transition-colors">
                            {{ $review->is_visible ? 'Ocultar' : 'Mostrar' }}
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div>{{ $reviews->links() }}</div>
</div>
