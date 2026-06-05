<div class="max-w-6xl mx-auto px-4 md:px-8 py-8 flex flex-col gap-6">

    <div>
        <p class="text-xs font-bold tracking-widest uppercase text-lm-primary mb-1">Administración</p>
        <h1 class="text-2xl font-bold text-lm-on-surface">Panel de control</h1>
        <p class="text-sm mt-0.5 text-lm-outline">Métricas generales y actividad reciente de la plataforma.</p>
    </div>

    {{-- Métricas --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-lm-outline-variant px-5 py-5 flex flex-col gap-2">
            <div class="flex items-center justify-between text-lm-secondary">
                <span class="text-xs font-semibold">Usuarios</span>
                <span class="material-symbols-outlined text-xl leading-none">people</span>
            </div>
            <div class="text-3xl font-bold text-lm-primary">{{ $totalUsers }}</div>
            <div class="text-xs text-lm-outline">{{ $candidateCount }} candidatos · {{ $employerCount }} empleadores</div>
        </div>

        <div class="bg-white rounded-xl border border-lm-outline-variant px-5 py-5 flex flex-col gap-2">
            <div class="flex items-center justify-between text-lm-secondary">
                <span class="text-xs font-semibold">Empresas</span>
                <span class="material-symbols-outlined text-xl leading-none">business</span>
            </div>
            <div class="text-3xl font-bold text-lm-primary">{{ $totalCompanies }}</div>
            <div class="text-xs text-lm-outline">{{ $activeCompanies }} activas</div>
        </div>

        <div class="bg-white rounded-xl border border-lm-outline-variant px-5 py-5 flex flex-col gap-2">
            <div class="flex items-center justify-between text-lm-secondary">
                <span class="text-xs font-semibold">Ofertas</span>
                <span class="material-symbols-outlined text-xl leading-none">work</span>
            </div>
            <div class="text-3xl font-bold text-lm-primary">{{ $totalJobPosts }}</div>
            <div class="text-xs text-lm-outline">{{ $publishedJobs }} publicadas</div>
        </div>

        <div class="bg-white rounded-xl border border-lm-outline-variant px-5 py-5 flex flex-col gap-2">
            <div class="flex items-center justify-between text-lm-secondary">
                <span class="text-xs font-semibold">Postulaciones</span>
                <span class="material-symbols-outlined text-xl leading-none">description</span>
            </div>
            <div class="text-3xl font-bold text-lm-primary">{{ $totalApplications }}</div>
            <div class="text-xs text-lm-outline">{{ $activeConversations }} conversaciones activas</div>
        </div>
    </div>

    {{-- Reviews --}}
    <div class="bg-white rounded-xl border border-lm-outline-variant px-6 py-5 flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-bold text-lm-on-surface">Calificaciones recientes</h2>
            <a href="{{ route('admin.reviews.index') }}" wire:navigate class="text-xs font-semibold text-lm-primary hover:underline">Ver todas</a>
        </div>
        @forelse ($recentReviews as $review)
            <div class="flex items-center justify-between gap-3 p-3 rounded-lg border border-lm-surface-highest">
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-lm-on-surface truncate">{{ $review->reviewer->name }}</p>
                    <p class="text-xs text-lm-outline">{{ $review->jobApplication?->jobPost?->title }} · {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</p>
                </div>
                <span @class([
                    'text-[11px] font-bold px-2 py-0.5 rounded-full',
                    'bg-green-50 text-green-700' => $review->is_visible,
                    'bg-lm-surface-highest text-lm-secondary' => ! $review->is_visible,
                ])>
                    {{ $review->is_visible ? 'Visible' : 'Oculta' }}
                </span>
            </div>
        @empty
            <p class="text-sm text-lm-outline text-center py-4">Sin calificaciones todavía.</p>
        @endforelse
    </div>

    {{-- Últimos usuarios --}}
    <div class="bg-white rounded-xl border border-lm-outline-variant px-6 py-5 flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-bold text-lm-on-surface">Últimos registros</h2>
            <a href="{{ route('admin.users.index') }}" wire:navigate class="text-xs font-semibold text-lm-primary hover:underline">Ver todos</a>
        </div>
        @forelse ($recentUsers as $user)
            <div class="flex items-center justify-between gap-3 p-3 rounded-lg border border-lm-surface-highest">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-lm-secondary-container flex items-center justify-center shrink-0">
                        <span class="text-xs font-bold text-lm-primary">{{ $user->initials() }}</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-lm-on-surface truncate">{{ $user->name }}</p>
                        <p class="text-xs text-lm-outline">{{ $user->email }}</p>
                    </div>
                </div>
                <span @class([
                    'text-[11px] font-bold px-2 py-0.5 rounded-full capitalize',
                    'bg-lm-secondary-container text-lm-primary' => $user->role === 'candidate',
                    'bg-lm-surface-highest text-lm-secondary' => $user->role === 'employer',
                    'bg-blue-50 text-blue-700' => $user->role === 'admin',
                ])>
                    {{ $user->role }}
                </span>
            </div>
        @empty
            <p class="text-sm text-lm-outline text-center py-4">Sin usuarios.</p>
        @endforelse
    </div>
</div>
