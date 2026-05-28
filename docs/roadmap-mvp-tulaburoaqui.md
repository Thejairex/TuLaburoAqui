# Roadmap MVP — TuLaburoAquí

Documento maestro de roadmap para el MVP de la plataforma laboral tipo marketplace, orientada a conectar trabajadores operativos/técnicos con empresas contratantes.[cite:1] El alcance funcional base del MVP incluye registro, perfiles visuales, publicación de trabajos, búsqueda, match básico, mensajería simple y panel administrativo básico.[cite:1][cite:2]

## Contexto del proyecto

El proyecto fue definido como una plataforma laboral tipo "Airbnb laboral" o "LinkedIn simplificado", enfocada en trabajos operativos y técnicos, con proyección local e internacional.[cite:1] El documento funcional establece que la primera etapa debe resolverse como un MVP para validar la idea, iniciar pruebas reales y controlar costos antes de una versión más compleja.[cite:1]

## Stack objetivo del Space

Este roadmap está alineado al stack operativo del Space: Laravel 13 como backend principal, Livewire para frontend reactivo, PostgreSQL como base de datos, Docker + Coolify para despliegue y storage compatible con S3 para CVs, fotos y logos.[cite:2] La base documental disponible ya modela el MVP pensando exactamente en ese stack y contempla futura extensión mediante microservicios Python si luego hiciera falta OCR, IA o procesamiento adicional.[cite:2]

## Criterios de organización del roadmap

Se reorganizó el roadmap separando el dashboard como una fase propia, porque en este producto no funciona solo como una pantalla de entrada sino como la capa operativa principal para cada tipo de usuario: trabajador y empresa.[cite:1][cite:2] Esta reorganización mejora la estimación, reduce la mezcla de responsabilidades entre onboarding y operación diaria, y permite implementar con más claridad layouts, flujos y permisos por rol en Laravel + Livewire.[cite:2]

## Vista general de fases

| Fase | Nombre | Objetivo principal | Duración sugerida |
|---|---|---|---|
| 0 | Fundación técnica | Preparar infraestructura, auth base, migraciones y arquitectura inicial | Semanas 1–2 [cite:2] |
| 1 | Registro y acceso | Crear identidad de usuario y entrada al sistema según rol | Semana 3 [cite:1][cite:2] |
| 2 | Perfiles y archivos | Construir perfiles visuales y carga de CV, foto y logo | Semanas 4–5 [cite:1][cite:2] |
| 3 | Dashboards por rol | Crear home operativa para trabajador y empresa | Semanas 6–7 [cite:1][cite:2] |
| 4 | Ofertas y búsqueda | Publicación de trabajos, listados y filtros | Semanas 8–9 [cite:1][cite:2] |
| 5 | Match y mensajería | Postulaciones, score básico y chat interno | Semanas 10–11 [cite:1][cite:2] |
| 6 | Calificaciones y administración | Reviews, moderación y panel admin base | Semana 12 [cite:1][cite:2] |

## Fase 0 — Fundación técnica

Esta fase prepara la base del sistema para que el resto del MVP crezca sin retrabajo estructural.[cite:2] La documentación de base de datos ya recomienda UUIDs, relaciones Eloquent desde el inicio, storage desacoplado y estados simples en varchar para acelerar el MVP.[cite:2]

### Objetivos

- Configurar Docker para desarrollo local y despliegue vía Coolify.[cite:2]
- Configurar Laravel 13, Livewire, PostgreSQL y filesystem para S3 o compatible.[cite:2]
- Crear migraciones, seeders y factories iniciales.[cite:2]
- Implementar auth base y separación por rol (`worker`, `company_admin`, `admin`).[cite:2]
- Dejar políticas, middlewares y estructura de layouts autenticados preparados para fases posteriores.[cite:2]

### Tablas involucradas

- `users` [cite:2]
- `worker_profiles` [cite:2]
- `companies` [cite:2]
- `company_members` [cite:2]
- `skills` [cite:2]
- `files` [cite:2]

### Entregables

- Proyecto Laravel inicial funcionando en local y staging.[cite:2]
- Migraciones ejecutables sin errores.[cite:2]
- Seeders básicos de roles, estados y skills iniciales.[cite:2]
- Base de autenticación lista para redirigir por rol.[cite:2]

### Criterio de done

La fase se considera terminada cuando `migrate --seed` funciona correctamente, el login base está operativo y el proyecto puede desplegarse en un entorno de staging con PostgreSQL y storage configurado.[cite:2]

## Fase 1 — Registro y acceso

El documento funcional indica que el registro es obligatorio y que el usuario debe elegir entre buscar trabajo u ofrecer trabajo, lo cual define el tipo de perfil.[cite:1] Esta fase resuelve identidad y acceso, pero no intenta todavía cubrir toda la experiencia operativa del usuario autenticado.[cite:1][cite:2]

### Objetivos

- Registro de trabajador.[cite:1]
- Registro de empresa o representante de empresa.[cite:1][cite:2]
- Login, logout y recuperación básica de acceso.[cite:2]
- Redirección inicial según rol luego de autenticación.[cite:2]
- Estados iniciales de usuario (`active`, `pending_verification`, `blocked`).[cite:2]

### Alcance funcional

Para trabajadores, el registro debe contemplar nombre, email, teléfono, país, ciudad y los datos mínimos necesarios para empezar a construir el perfil laboral.[cite:1] Para empresas, el alta debe contemplar nombre de empresa, email, teléfono, dirección, tipo de negocio y cantidad de empleados como base de identidad empresarial.[cite:1]

### Tablas involucradas

- `users` [cite:2]
- `companies` [cite:2]
- `company_members` [cite:2]

### Entregables

- Formularios de alta por tipo de usuario.[cite:1]
- Flujo de autenticación funcional.[cite:2]
- Redirección al flujo correspondiente según rol.[cite:2]

### Criterio de done

La fase queda cerrada cuando un trabajador y una empresa pueden registrarse, autenticarse y entrar al sistema con su rol correcto persistido en base de datos.[cite:1][cite:2]

## Fase 2 — Perfiles y archivos

El documento funcional define el perfil visual como un diferencial clave bajo el concepto de "Instagram laboral" y exige que el trabajador tenga foto, experiencia, CV, habilidades, historial y reputación, mientras que la empresa debe tener logo, información empresarial, historial y publicaciones activas.[cite:1] La base de datos ya contempla este alcance mediante `worker_profiles`, `worker_skills`, `skills`, `companies` y `files`.[cite:1][cite:2]

### Objetivos

- Crear perfil público y editable de trabajador.[cite:1][cite:2]
- Crear perfil público y editable de empresa.[cite:1][cite:2]
- Subir avatar, CV PDF y logo. [cite:1][cite:2]
- Manejar habilidades del trabajador y skills asociadas.[cite:2]
- Calcular completitud de perfil para guiar el onboarding posterior.[cite:2]

### Tablas involucradas

| Tabla | Uso principal |
|---|---|
| `worker_profiles` | Perfil extendido del trabajador, incluyendo disponibilidad, bio, salario esperado, foto y CV.[cite:2] |
| `worker_skills` | Asociación de skills del trabajador con nivel y experiencia.[cite:2] |
| `skills` | Catálogo centralizado para matching y filtros.[cite:2] |
| `companies` | Perfil empresarial visible y editable.[cite:2] |
| `files` | Persistencia de CVs, avatares, logos y adjuntos.[cite:2] |

### Entregables

- Vista pública de perfil trabajador.[cite:1][cite:2]
- Vista pública de perfil empresa.[cite:1][cite:2]
- Componentes Livewire para edición de perfil.[cite:2]
- Carga y reemplazo de archivos en S3.[cite:2]

### Ajustes sugeridos de BD

Conviene agregar `companies.is_profile_complete boolean default false` para que la empresa tenga una lógica de completitud equivalente a la que ya existe en `worker_profiles.is_profile_complete`.[cite:2] También conviene formalizar el uso de `files.kind` para distinguir al menos `cv`, `avatar`, `company_logo` y `attachment`.[cite:2]

### Criterio de done

La fase se considera completa cuando ambos tipos de usuario tienen perfil visual visible, editable y con soporte de archivos funcionando correctamente.[cite:1][cite:2]

## Fase 3 — Dashboards por rol

Esta fase fue separada deliberadamente porque el dashboard tiene responsabilidades propias y distintas al registro y al perfil público.[cite:1][cite:2] En este producto, el dashboard debe actuar como centro operativo autenticado, no solo como landing interna.[cite:2]

### Objetivos

- Crear dashboard principal para trabajador.[cite:2]
- Crear dashboard principal para empresa.[cite:2]
- Mostrar progreso de completitud y acciones pendientes.[cite:2]
- Exponer accesos rápidos a edición, carga de archivos, ofertas, postulaciones y mensajería futura según corresponda.[cite:1][cite:2]

### Dashboard trabajador

El dashboard trabajador debe mostrar estado de perfil, acciones para completar datos faltantes, subida o actualización de CV, edición de skills y disponibilidad laboral.[cite:1][cite:2] A medida que se activen las fases siguientes, también debe centralizar postulaciones, mensajes y reputación del usuario.[cite:1][cite:2]

### Dashboard empresa

El dashboard empresa debe mostrar estado del perfil empresarial, edición de datos, carga de logo, CTA para crear oferta y luego resumen de ofertas y postulaciones.[cite:1][cite:2] Esta pantalla será el principal centro de operación para cuentas empleadoras dentro del MVP.[cite:1]

### Tablas involucradas

- `users` [cite:2]
- `worker_profiles` [cite:2]
- `worker_skills` [cite:2]
- `companies` [cite:2]
- `company_members` [cite:2]
- `files` [cite:2]
- `job_posts` en lectura parcial para futuros accesos rápidos.[cite:2]
- `job_applications` en lectura parcial para futuros widgets de estado.[cite:2]

### Entregables

- Layout autenticado por rol.[cite:2]
- Dashboard trabajador funcional.[cite:2]
- Dashboard empresa funcional.[cite:2]
- Checklists o indicadores de perfil completo.[cite:2]
- Navegación interna coherente para fases siguientes.[cite:2]

### Criterio de done

La fase se cierra cuando cada usuario entra a un dashboard consistente con su rol y puede operar las tareas principales de su etapa actual sin depender de rutas técnicas dispersas.[cite:2]

## Fase 4 — Ofertas y búsqueda

El documento funcional establece que la publicación de trabajos es exclusiva para empresas y que el sistema debe permitir búsqueda y filtros por ubicación, experiencia, disponibilidad, tipo de trabajo y salario.[cite:1] La base de datos ya modela `job_posts`, `job_post_skills` y los índices recomendados para responder de forma eficiente en PostgreSQL.[cite:1][cite:2]

### Objetivos

- CRUD de ofertas laborales para empresa.[cite:1][cite:2]
- Publicación y cambio de estado de ofertas (`draft`, `published`, `paused`, `closed`, `expired`).[cite:2]
- Buscador de trabajos con filtros reactivos en Livewire.[cite:1][cite:2]
- Visualización pública de oferta y de empresa publicante.[cite:1][cite:2]

### Tablas involucradas

- `job_posts` [cite:2]
- `job_post_skills` [cite:2]
- `skills` [cite:2]
- `companies` [cite:2]

### Índices críticos

La documentación recomienda explícitamente índices sobre `job_posts(status, published_at)` y `job_posts(city, province)` para acelerar listados, búsqueda y filtros del MVP.[cite:2] Implementarlos desde esta fase reduce problemas de performance cuando empiecen a crecer publicaciones y búsquedas concurrentes.[cite:2]

### Entregables

- Alta, edición y publicación de ofertas.[cite:1][cite:2]
- Listado público de ofertas.[cite:1][cite:2]
- Filtros y ordenamiento por criterios relevantes del negocio.[cite:1][cite:2]

### Criterio de done

La fase queda cerrada cuando una empresa puede publicar un trabajo y un trabajador puede encontrarlo con filtros operativos reales.[cite:1][cite:2]

## Fase 5 — Match y mensajería

El sistema debe conectar trabajador y empresa cuando exista compatibilidad, incluyendo búsqueda de candidatos, búsqueda de trabajos, contacto directo y notificación de coincidencias.[cite:1] En el MVP, ese match puede resolverse con lógica simple basada en skills y flujos de postulación, sin IA avanzada.[cite:1][cite:2]

### Objetivos

- Crear postulación a oferta desde trabajador.[cite:2]
- Gestionar estados de postulación (`submitted`, `in_review`, `shortlisted`, `rejected`, `hired`, `withdrawn`).[cite:2]
- Calcular `match_score` básico usando overlap de skills y condiciones mínimas.[cite:2]
- Abrir conversación interna luego del avance de una postulación o match.[cite:1][cite:2]
- Habilitar mensajería simple con historial y lectura.[cite:1][cite:2]

### Tablas involucradas

| Tabla | Responsabilidad |
|---|---|
| `job_applications` | Registro de postulaciones, estados y score de match.[cite:2] |
| `conversations` | Hilo principal de conversación entre partes.[cite:2] |
| `conversation_participants` | Participantes por conversación.[cite:2] |
| `messages` | Mensajes individuales y control de lectura.[cite:2] |

### Entregables

- Botón de postulación y flujo asociado.[cite:2]
- Vista de candidatos para empresa y de postulaciones para trabajador.[cite:1][cite:2]
- Chat interno simple por conversación.[cite:1][cite:2]
- Notificaciones internas básicas asociadas a actividad de match o mensaje.[cite:1]

### Criterio de done

La fase se considera completa cuando existe un flujo real desde oferta publicada hasta postulación, revisión y conversación entre trabajador y empresa.[cite:1][cite:2]

## Fase 6 — Calificaciones y administración

El documento funcional exige reputación mediante calificaciones y también un panel administrativo básico con gestión de usuarios, empresas, moderación y estadísticas.[cite:1] La estructura de `reviews` y la presencia del rol `admin` en `users` permiten resolver este bloque dentro del MVP.[cite:1][cite:2]

### Objetivos

- Permitir reviews luego de una relación laboral o avance relevante del proceso.[cite:1][cite:2]
- Actualizar métricas de reputación para trabajadores y empresas.[cite:1][cite:2]
- Crear panel administrativo base con moderación, gestión y métricas iniciales.[cite:1]

### Tablas involucradas

- `reviews` [cite:2]
- `users` [cite:2]
- `companies` [cite:2]
- `job_posts` [cite:2]
- `job_applications` [cite:2]

### Entregables

- Calificaciones visibles en perfiles cuando corresponda.[cite:1][cite:2]
- Herramientas admin para bloquear, moderar y revisar actividad esencial.[cite:1][cite:2]
- Estadísticas base del MVP: usuarios, empresas, ofertas, postulaciones y conversaciones.[cite:1]

### Criterio de done

La fase queda terminada cuando la plataforma tiene reputación mínima funcional y un panel interno suficiente para operar el MVP con control administrativo básico.[cite:1][cite:2]

## Sprint plan sugerido

La siguiente distribución ayuda a mantener foco funcional por sprint, reduce mezcla de responsabilidades y se adapta bien a un equipo pequeño trabajando sobre Laravel + Livewire.[cite:2]

| Sprint | Semanas | Fase | Resultado esperado |
|---|---|---|---|
| 1 | 1–2 | Fundación técnica | Infraestructura, auth base, migraciones, seeders y staging.[cite:2] |
| 2 | 3 | Registro y acceso | Alta por tipo de usuario y autenticación operativa.[cite:1][cite:2] |
| 3 | 4–5 | Perfiles y archivos | Perfiles visuales y subida de archivos en S3.[cite:1][cite:2] |
| 4 | 6–7 | Dashboards por rol | Home operativa para trabajador y empresa.[cite:2] |
| 5 | 8–9 | Ofertas y búsqueda | Publicaciones, listados y filtros reactivos.[cite:1][cite:2] |
| 6 | 10–11 | Match y mensajería | Postulación, score básico y conversaciones.[cite:1][cite:2] |
| 7 | 12 | Calificaciones y administración | Reviews, moderación y admin base.[cite:1][cite:2] |

## Dependencias críticas

El orden de fases no es arbitrario: las ofertas dependen de empresas con perfil; el match depende de ofertas y perfiles; la mensajería depende de postulaciones o conversaciones abiertas; y las reviews dependen de una relación previa trazable en el sistema.[cite:1][cite:2] Mantener este orden reduce deuda técnica y evita construir pantallas sin contexto funcional real.[cite:2]

## Cambios recomendados sobre la base actual

| Cambio | Motivo |
|---|---|
| Agregar `companies.is_profile_complete` | Permitir completitud simétrica entre trabajador y empresa dentro del onboarding y dashboard.[cite:2] |
| Formalizar `files.kind` | Diferenciar `cv`, `avatar`, `company_logo` y adjuntos desde el inicio.[cite:2] |
| Mantener `company_members` desde MVP | Evitar rediseño posterior cuando una empresa tenga más de un usuario administrador o reclutador.[cite:2] |
| Dejar `location` nullable por ahora | La documentación recomienda no forzar geolocalización real en una etapa temprana del MVP.[cite:2] |

## Riesgos principales

El principal riesgo funcional es inflar fases tempranas mezclando registro, perfil, dashboard, ofertas y matching al mismo tiempo, porque eso rompe foco y vuelve más difícil testear con usuarios reales.[cite:1][cite:2] El principal riesgo técnico es postergar decisiones simples de modelo, permisos y archivos, ya que luego impactan transversalmente en perfiles, dashboards, ofertas y mensajería.[cite:2]

## Prioridades Post-MVP

El documento funcional deja fuera del MVP la IA avanzada, las automatizaciones complejas, la escalabilidad masiva y las apps móviles.[cite:1] También deja planteada la internacionalización como un eje estratégico futuro, especialmente para programas laborales hacia países como Japón y Estados Unidos, por lo que conviene diseñar desde ahora sin bloquear esa evolución.[cite:1]

## Conclusión operativa

Este roadmap reordenado mantiene intacto el alcance funcional del MVP definido en la documentación, pero mejora la secuencia de implementación al separar identidad, perfil, operación, oferta, conexión y administración en fases coherentes.[cite:1][cite:2] Para el stack del Space, esta organización favorece una ejecución más clara en Laravel + Livewire, con menor riesgo de retrabajo y mejor capacidad de validación temprana con usuarios reales.[cite:2]
