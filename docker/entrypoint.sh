#!/bin/sh

if [ -f /var/www/html/.env ]; then
    php artisan migrate --force 2>/dev/null || true
fi

exec "$@"
