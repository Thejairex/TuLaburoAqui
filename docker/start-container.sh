#!/usr/bin/env bash
set -e

# ─── Esperar DB ───────────────────────────────────────────────────────────────
if [ -n "$DB_HOST" ]; then
    echo "Waiting for database at $DB_HOST:${DB_PORT:-5432}..."
    until php -r "new PDO('pgsql:host=$DB_HOST;port=${DB_PORT:-5432};dbname=$DB_DATABASE', '$DB_USERNAME', '$DB_PASSWORD');" 2>/dev/null; do
        sleep 1
    done
    echo "Database is ready."
fi

# ─── Laravel bootstrap ────────────────────────────────────────────────────────
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link --force 2>/dev/null || true

# ─── Iniciar PHP-FPM ──────────────────────────────────────────────────────────
exec php-fpm
