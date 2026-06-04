# AGENTS.md — TuLaburoAquí / LaborMarket

## Comandos críticos

| Contexto | Comando |
|---|---|
| Setup inicial | `composer run setup` |
| Dev completo (servidor + queue + Vite) | `composer run dev` |
| Solo Vite | `npm run dev` |
| Build producción | `npm run build` |
| Lint (Pint, corrige) | `composer run lint` |
| Lint check | `composer run lint:check` |
| Tests completos | `composer run test` o `C:\php\8.4\php.exe vendor/bin/pest` |
| Test específico | `C:\php\8.4\php.exe vendor/bin/pest tests/Feature/Auth/LoginTest.php` |
| Test por nombre | `C:\php\8.4\php.exe vendor/bin/pest --filter "can login"` |

**PHP 8.4** — siempre usar `C:\php\8.4\php.exe` (nunca `php` a secas).

## Stack

- **Laravel 13** + **Livewire 4** (UI reactiva, no controladores tradicionales)
- **Laravel Fortify** (login, 2FA, passkeys, email verification, password reset)
- **Tailwind CSS 4** + **Vite** (build: `npm run build`)
- **Pest 4** con sintaxis `test()` (no PHPUnit nativo)
- **Spatie MediaLibrary** (archivos: avatar, cv, logo — no usar `Storage` facade)
- **SQLite** por defecto, **PostgreSQL** en producción (Docker + Coolify)

## Arquitectura

```
app/
├── Actions/Fortify/       → Lógica de auth (CreateNewUser, ResetUserPassword)
├── Concerns/              → Traits de validación reutilizables (PasswordValidationRules, etc.)
├── Livewire/              → Componentes de UI organizados por módulo
├── Models/                → Eloquent models (HasUuids, InteractsWithMedia)
├── Providers/             → AppServiceProvider, FortifyServiceProvider
└── Services/              → Lógica de negocio (JobPostService, *Completeness)
routes/
├── web.php                → Rutas principales + require settings.php
└── settings.php           → Perfil, apariencia, seguridad
```

- **Livewire** = capa de presentación (no controllers HTTP)
- **Services** = lógica de negocio (no en Livewire ni controllers)
- **Concerns** = validación compartida entre Actions y Livewire
- **FortifyServiceProvider** mapea vistas a `livewire.*` y configura rate limiting

## Roles y rutas clave

Roles: `candidate`, `employer`, `admin`

- `/dashboard` → redirige según rol
- `/dashboard/candidate` — `role:candidate`
- `/dashboard/employer` — `role:employer`
- `/profile/edit` — `role:candidate`
- `/company/edit` — `role:employer`
- `/mis-ofertas` — CRUD de ofertas (`role:employer`)
- `/ofertas` — buscador público
- `/ofertas/{jobPost}` — detalle público de oferta
- `/empresa/{company}` — perfil público de empresa
- `/settings/profile`, `/settings/appearance`, `/settings/security`

## Testing

- SQLite en memoria (phpunit.xml), Bcrypt rounds=4, Queue=sync
- Factories: `User::factory()->create()`, `->unverified()`, `->withTwoFactor()`
- Pest feature tests extienden `Tests\TestCase` (con RefreshDatabase comentado en Pest.php)
- CI: `composer run ci:check` = lint check + tests, corre en PHP 8.3/8.4/8.5

## Modelos principales

- **User**: UUID, roles (`candidate`/`employer`/`admin`), status, Spatie media `avatar`, Fortify 2FA + passkeys
- **WorkerProfile**: UUID, Spatie media `cv`, belongsTo User, skills many-to-many vía `worker_skills`
- **Company**: UUID, slug, Spatie media `company_logo`, company_members
- **JobPost**: UUID, statuses `draft/published/paused/closed/expired`, scopes `published()`, `forCompany()`, skills many-to-many vía `job_post_skills` (pivot: `required`, `priority`)
- **JobApplication**: UUID, statuses `submitted/in_review/shortlisted/rejected/hired/withdrawn`, match_score
- **Conversation/Message/Participant**: mensajería interna
- **Review**: calificaciones
- Todos los models con UUIDs (`HasUuids`)

## Despliegue

`docker-compose.yml` → nginx + PHP 8.4-fpm + supervisor, puerto 8100. Dockerfile 3-stage build (composer → node → production). Coolify deploy via git push a branches `develop`/`main`.

## Convenciones

- Livewire para toda interacción reactiva antes de JS puro
- Migraciones con foreign keys y soft deletes
- No usar `Storage` facade para archivos de usuario — usar Spatie MediaLibrary API
- Pint preset `laravel` (composer run lint)
- EditorConfig: indent=4 spaces, LF endings
- Password rules: solo en producción (12+ chars, mixed, numbers, symbols, uncompromised)
- Rate limits: login=5/min, 2FA=5/min, passkeys=10/min
- Stitch design ref: proyecto "LaborMarket" (Hanken Grotesk, #0052cc, 8px esquinas)

## File uploads (Spatie MediaLibrary)

| Modelo | Colección | MIME |
|---|---|---|
| User | `avatar` | image/jpeg, image/png, image/webp |
| WorkerProfile | `cv` | application/pdf |
| Company | `company_logo` | (multi-file, sin MIME filter visible) |

Usar `$model->addMedia($file)->toMediaCollection('collection')` y `$model->getFirstMediaUrl('collection')`.

## Roadmap MVP

| Fase | Estado |
|---|---|
| 0 Fundación técnica | ✅ |
| 1 Registro y acceso | ✅ |
| 2 Perfiles y archivos | ✅ |
| 3 Dashboards por rol | ✅ |
| 4 Ofertas y búsqueda | ✅ |
| 5 Match y mensajería | ⏳ En curso |
| 6 Calificaciones y admin | ⏳ Pendiente |

Ver `docs/roadmap-mvp-tulaburoaqui.md` para criterios de done.
