# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Comandos principales

```bash
# Configuración inicial
composer run setup        # Instala dependencias, genera clave, migra DB y compila assets

# Desarrollo
composer run dev          # Inicia servidor, queue worker y Vite en paralelo (recomendado)
npm run dev               # Solo Vite (CSS/JS watch)
npm run build             # Build de producción

# Calidad de código
composer run lint         # Formatea código con Pint (corrige)
composer run lint:check   # Verifica formato sin corregir

# Tests
composer run test         # Lint check + suite completa de Pest
composer run ci:check     # Igual que test (usado en CI/CD)
C:\php\8.4\php.exe vendor/bin/pest tests/Feature/Auth/LoginTest.php  # Ejecutar un test específico
C:\php\8.4\php.exe vendor/bin/pest --filter "can login"              # Ejecutar por nombre de test
```

## Entorno PHP

**PHP 8.4** — usar siempre el ejecutable en `C:\php\8.4\php.exe` para todos los comandos PHP.

Ejemplos:
```powershell
C:\php\8.4\php.exe artisan migrate
C:\php\8.4\php.exe artisan test
C:\php\8.4\php.exe vendor/bin/pest
```

> IMPORTANTE: nunca usar `php` a secas en PowerShell desde este proyecto; usar siempre la ruta completa `C:\php\8.4\php.exe`.

## Stack tecnológico

- **Laravel 13** + **PHP 8.4**
- **Livewire 4** para componentes reactivos
- **Laravel Fortify** para autenticación (2FA, passkeys, verificación de email)
- **Tailwind CSS 4** con Vite
- **Pest 4** para testing
- **SQLite** por defecto (configurable a MySQL/PostgreSQL)
- **Laravel Pint** para formateo de código

## Arquitectura

### Patrón de Actions (app/Actions/)
La lógica de negocio de autenticación va en Actions que implementan contratos de Fortify:
- `Actions/Fortify/CreateNewUser.php` — registro de usuario
- `Actions/Fortify/ResetUserPassword.php` — reseteo de contraseña

### Livewire como capa de presentación (app/Livewire/)
Todos los componentes de UI son Livewire (no controladores HTTP tradicionales):
- `Livewire/Settings/` — Profile, Security, Appearance, DeleteUserForm
- Las vistas de Fortify se mapean a componentes Livewire en `FortifyServiceProvider`

### Concerns para validación compartida (app/Concerns/)
Las reglas de validación reutilizables viven en traits:
- `PasswordValidationRules` — reglas para contraseñas
- `ProfileValidationRules` — reglas para perfil de usuario

Usarlos en Actions y Livewire components en lugar de duplicar reglas.

### Rutas
- `routes/web.php` — rutas principales (welcome, dashboard)
- `routes/settings.php` — rutas de settings (incluido desde web.php)
- Fortify gestiona automáticamente sus propias rutas (login, register, 2FA, etc.)

## Configuración de entornos

**Producción** (AppServiceProvider):
- Contraseña mínima 12 caracteres + mayúsculas + números + símbolos + no comprometida
- Comandos destructivos de DB prohibidos

**Desarrollo/Testing**:
- Sin restricciones de contraseña
- SQLite en memoria para tests (`phpunit.xml`)
- Bcrypt rounds: 4 (más rápido en tests)
- Queue: sync (ejecución inmediata en tests)

## Testing

Los tests usan Pest con sintaxis `test()` y helpers de Laravel:

```php
test('usuarios autenticados pueden ver el dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user)->get('/dashboard')->assertOk();
});
```

Factories disponibles:
- `User::factory()->create()` — usuario verificado
- `User::factory()->unverified()->create()` — usuario sin verificar email
- `User::factory()->withTwoFactor()->create()` — usuario con 2FA activo

## Rate limiting (Fortify)

Configurado en `FortifyServiceProvider`:
- Login: 5 intentos/min por email+IP
- Two-Factor: 5 intentos/min por sesión
- Passkeys: 10 intentos/min por credential+IP

## Diseño UI (Stitch)

El proyecto de diseño de referencia es **LaborMarket** en Stitch:
- ID: `projects/1055399330902105321`
- Tema: "Operational Professional" · Fuente: Hanken Grotesk · Modo claro
- Color primario: `#0052cc` · Esquinas: 8px · Espaciado base: 8px

Siempre usar este proyecto como referencia al generar pantallas, componentes o diseños con Stitch MCP. Aplicar el design system de LaborMarket por defecto sin necesidad de que el usuario lo indique.

## Roadmap MVP

El roadmap completo está en `docs/roadmap-mvp-tulaburoaqui.md`. Siempre consultarlo para entender el contexto, fase actual y criterios de done antes de implementar cualquier funcionalidad nueva.

### Fases
| Fase | Nombre | Estado |
|------|--------|--------|
| 0 | Fundación técnica | ✅ Completa |
| 1 | Registro y acceso | ✅ Completa |
| 2 | Perfiles y archivos | ✅ Completa |
| 3 | Dashboards por rol | ✅ Completa |
| 4 | Ofertas y búsqueda | ⏳ En curso |
| 5 | Match y mensajería | ⏳ Pendiente |
| 6 | Calificaciones y administración | ⏳ Pendiente |

### Fase actual: 4 — Ofertas y búsqueda
Próximo paso: CRUD de ofertas laborales para empresa (estados draft/published/paused/closed/expired) y buscador con filtros reactivos en Livewire.

Fase 3 cerrada: dashboards de candidato y empresa con progreso de completitud, checklist de acciones pendientes (CTA con deep-link a secciones del editor) y accesos rápidos (edición, carga de archivos, ofertas, postulaciones y mensajería según rol). Lógica de completitud en `WorkerProfileCompleteness` y `CompanyCompleteness` (app/Services).

Estrategia adoptada: **registro corto + onboarding progresivo en dashboard** (teléfono, país, ciudad y datos adicionales se completan en esta fase).

## Manejo de archivos

Todos los archivos (CV, avatar, logo de empresa) se manejan con **Spatie MediaLibrary** (`spatie/laravel-medialibrary`), ya instalada en el proyecto.

- Los modelos que suben archivos deben usar el trait `InteractsWithMedia` e implementar `HasMedia`
- Colecciones definidas: `avatar` (usuarios), `cv` (candidatos), `company_logo` (empresas)
- No usar `Storage` facade directamente para estos archivos — usar siempre la API de MediaLibrary

## Reglas de desarrollo
- Usar Livewire para toda interacción reactiva antes de considerar JS puro
- Los componentes Livewire van en `app/Livewire/` organizados por módulo
- La lógica de negocio va en `app/Services/`, no en controllers ni Livewire
- Migraciones siempre con foreign keys y soft deletes donde aplique
- Los microservicios Python se comunican via HTTP interno en Docker
