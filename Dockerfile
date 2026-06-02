# ─── Stage 1: Install PHP dependencies (vendor/ needed by Vite) ───────────────
FROM composer:2 AS composer-builder

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --ignore-platform-reqs

COPY . .
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --ignore-platform-reqs

# ─── Stage 2: Build frontend assets (needs vendor/ from composer) ─────────────
FROM node:22-alpine AS node-builder

WORKDIR /app

COPY package.json package-lock.json .npmrc ./
RUN npm ci --no-audit --no-fund

COPY . .
# Copiar vendor/ desde composer-builder para que flux.css sea resolvible
COPY --from=composer-builder /app/vendor ./vendor

RUN npm run build

# ─── Stage 3: Production image ────────────────────────────────────────────────
FROM php:8.4-fpm-alpine

# Todas las libs de sistema necesarias para compilar las extensiones PHP
RUN apk add --no-cache \
    bash \
    curl \
    # pdo_pgsql
    postgresql-dev \
    # gd
    libpng-dev \
    libwebp-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    # zip
    libzip-dev \
    # mbstring
    oniguruma-dev \
    # pcntl / build headers
    linux-headers \
    # exif (spatie/medialibrary)
    libexif-dev \
    # pdo_sqlite
    sqlite-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pdo_sqlite \
        mbstring \
        xml \
        bcmath \
        gd \
        zip \
        opcache \
        pcntl \
        exif \
    && rm -rf /var/cache/apk/*

# Extensión Redis vía PECL (necesaria para REDIS_CLIENT=phpredis)
RUN pecl install redis && docker-php-ext-enable redis

COPY --from=composer-builder /app /app
COPY --from=node-builder /app/public/build /app/public/build

WORKDIR /app

RUN mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache public/build

COPY docker/php.ini $PHP_INI_DIR/conf.d/app.ini

RUN ln -sf /app/storage/app/public /app/public/storage

COPY docker/start-container.sh /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

# Cambiar PHP-FPM para escuchar en puerto 8100
RUN sed -i 's/listen = 127.0.0.1:9000/listen = 0.0.0.0:8100/' /usr/local/etc/php-fpm.d/www.conf \
    || sed -i 's/listen = 9000/listen = 0.0.0.0:8100/' /usr/local/etc/php-fpm.d/www.conf

EXPOSE 8100

ENTRYPOINT ["start-container"]
