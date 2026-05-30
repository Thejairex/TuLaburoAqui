#!/bin/bash
set -e

# Ensure storage and database directories exist
mkdir -p /app/storage/framework/cache/data \
    /app/storage/framework/sessions \
    /app/storage/framework/views \
    /app/storage/logs \
    /app/storage/app/public \
    /app/bootstrap/cache \
    /app/database

# Create SQLite database if it doesn't exist
if [ ! -f /app/database/database.sqlite ]; then
    touch /app/database/database.sqlite
fi

# Set proper permissions
chown -R www-data:www-data /app/storage /app/bootstrap/cache /app/database /app/public

# Generate .env if missing
if [ ! -f /app/.env ]; then
    cp /app/.env.example /app/.env
fi

# Laravel setup
php /app/artisan key:generate --force --quiet
php /app/artisan storage:link --force --quiet
php /app/artisan migrate --force --graceful --quiet

# Cache for production
php /app/artisan config:cache --quiet
php /app/artisan route:cache --quiet
php /app/artisan view:cache --quiet

exec php-fpm
