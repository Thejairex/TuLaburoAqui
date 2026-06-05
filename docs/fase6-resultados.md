# Fase 6 — Resultados de implementación

> Implementada el 2026-06-04. Estado: ✅ Completa.

## Problemas resueltos

### Bug: Redirect loop en dashboard para admin

**Síntoma:** `ERR_TOO_MANY_REDIRECTS` al hacer login como admin.

**Causa raíz (doble):**

1. `app/Http/Middleware/EnsureUserHasRole.php` — cuando el rol no coincidía, redirigía a `route('dashboard')`. El middleware `role:candidate` fallaba para admin → redirect a `/dashboard` → default iba a candidate → middleware fallaba → loop infinito.

2. Rutas cacheadas — después de editar `routes/web.php`, Laravel servía rutas viejas del cache. Solución: `php artisan route:clear`.

**Fix aplicado:**
- Middleware ahora llama `abort(403)` en vez de redirect (`EnsureUserHasRole.php:14`)
- Ruta `/dashboard` tiene case explícito para admin (`routes/web.php:40`)
- Se documentó en `AGENTS.md` que hay que correr `route:clear` si se editan rutas

## Archivos modificados/creados

### Middleware
- `app/Http/Middleware/EnsureUserHasRole.php` — soporte multi-role vía variadic `string ...$roles` + `abort(403)` en fallo

### Factory & Seeder
- `database/factories/UserFactory.php` — nuevo state `admin()` (setea `role => admin`)
- `database/seeders/DatabaseSeeder.php` — seedea admin user (`admin@tulaburoaqui.com` / `password`)

### Modelos
- `app/Models/Review.php` — constantes `TYPES`, scopes `visible()`, `ofType()`, `fromReviewer()`, `toReviewed()`
- `app/Models/User.php` — relaciones `reviewsGiven()`, `reviewsReceived()`, accessor `averageRating()`
- `app/Models/JobApplication.php` — relación `reviews()`
- `app/Models/Company.php` — método `ratingBadge()` (badge HTML con estrella + puntuación)

### Servicios
- `app/Services/ReviewService.php` — **creado**. Lógica central de reviews:
  - `createReview()` valida: roles permitidos, estado hired/rejected, duplicados, partes involucradas
  - Auto-aprueba (`is_visible = true`)
  - Recalcula `Company.avg_rating` y `ratings_count` para reviews candidate→employer
  - `canReview()` verifica si el usuario ya reviewó

### Componentes Livewire admin
- `app/Livewire/Admin/Dashboard.php` + vista — métricas: usuarios, empresas, ofertas, postulaciones, reviews recientes, últimos registros
- `app/Livewire/Admin/Users/Index.php` + vista — listado con búsqueda, filtro por rol/estado, botón bloquear/desbloquear
- `app/Livewire/Admin/Companies/Index.php` + vista — listado con búsqueda, empresas activas/bloqueadas, botón toggle
- `app/Livewire/Admin/JobPosts/Index.php` + vista — listado con búsqueda y filtro por estado, botón cerrar oferta
- `app/Livewire/Admin/Reviews/Index.php` + vista — listado con búsqueda y filtro, toggle visibilidad

### Review UI
- `app/Livewire/Company/Jobs/Applicants.php` — modal de review (1–5 estrellas + opcional comentario) para employer→candidate
- Vista asociada de Applicants — botón "Calificar" aparece en hired/rejected si no hay review del employer actual
- `app/Livewire/Applications/Index.php` — modal de review candidate→employer
- Vista asociada de Applications/Index — botón "Calificar empresa" en hired/rejected

### Rating display
- `resources/views/livewire/company/show.blade.php` — badge con estrellas junto a industry/location si `ratings_count > 0`

### Rutas admin
- `routes/web.php` — grupo `middleware('role:admin')->prefix('admin')->name('admin.')`:
  - `/admin` → Dashboard
  - `/admin/usuarios` → Users\Index
  - `/admin/empresas` → Companies\Index
  - `/admin/ofertas` → JobPosts\Index
  - `/admin/reviews` → Reviews\Index

### Navbar
- `resources/views/components/app-navbar.blade.php` — link "Admin" con icono shield en navbar desktop y menú mobile, visible solo si `role === admin`

### Documentación
- `AGENTS.md` — tabla de roadmap actualizada
- Este archivo

## Lo que NO se implementó (fuera de alcance MVP)

- Reviews con reply del reviewado
- Sistema de reportes/abuso
- Moderación de contenido de reviews (son auto-aprobadas)
- Admin puede banear usuarios permanentemente (solo toggle active/blocked)
- Dashboard admin con gráficas (solo números estáticos)
- CRUD completo de skills desde admin

## Testing

- `migrate:fresh --seed` → OK (crea admin user)
- `vendor/bin/pint` → limpio
- Tests existentes tienen error pre-existente (SQLite in-memory sin migrations) — no causado por esta fase

## Cómo probar

1. Login como `admin@tulaburoaqui.com` / `password`
2. `/dashboard` redirige a `/admin`
3. Verificar métricas en admin dashboard
4. Navegar a usuarios, empresas, ofertas, reviews
5. Probar bloquear/desbloquear usuario, cerrar oferta, toggle visibilidad de review
6. Login como employer con candidato hired/rejected → botón "Calificar"
7. Login como candidate con postulación hired/rejected → botón "Calificar empresa"
8. Ver estrella + puntuación en `/empresa/{company}`


## Tabla de implementaciones

| Elemento | Estado |
|---|---|
| `EnsureUserHasRole` multi-role support | ✅ |
| `UserFactory::admin()` state | ✅ |
| `DatabaseSeeder` admin user | ✅ |
| Review model (scopes, TYPES) | ✅ |
| User model (`reviewsGiven`, `reviewsReceived`, `averageRating`) | ✅ |
| `JobApplication` model (`reviews`) | ✅ |
| `Company` model (`ratingBadge`) | ✅ |
| `ReviewService` (`createReview` auto-approved) | ✅ |
| Admin components: Dashboard, Users, Companies, JobPosts, Reviews | ✅ |
| Review UI en Company/Jobs/Applicants | ✅ |
| Review UI en Applications/Index | ✅ |
| Rating badge en Company/Show | ✅ |
| Admin routes (`/admin`) | ✅ |
| Admin navbar link (desktop + mobile) | ✅ |
| `migrate:fresh --seed` | ✅ |
| `pint` limpio | ✅ |
| **Admin login:** `admin@tulaburoaqui.com` / `password` | — |
