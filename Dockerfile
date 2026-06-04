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

# ─── Stage 2: Build frontend assets ───────────────────────────────────────────────
FROM node:22-alpine AS node-builder

WORKDIR /app

COPY package.json package-lock.json .npmrc ./
RUN npm ci --no-audit --no-fund

COPY . .
COPY --from=composer-builder /app/vendor ./vendor

RUN npm run build

# ─── Stage 3: Production image (nginx + php-fpm en el mismo contenedor) ────────
FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    bash \
    curl \
    nginx \
    supervisor \
    autoconf \
    g++ \
    make \
    postgresql-dev \
    libpng-dev \
    libwebp-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    linux-headers \
    libexif-dev \
    sqlite-dev \
    libxml2-dev \
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
    && pecl install redis \
    && docker-php-ext-enable redis \
    && rm -rf /tmp/pear /var/cache/apk/*

COPY --from=composer-builder /app /app
COPY --from=node-builder /app/public/build /app/public/build

WORKDIR /app

RUN mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    /var/log/nginx \
    /var/log/supervisor \
    /run/nginx \
    && chown -R www-data:www-data storage bootstrap/cache public/build \
    && chown -R nginx:nginx /var/log/nginx /run/nginx

COPY docker/php.ini $PHP_INI_DIR/conf.d/app.ini
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN ln -sf /app/storage/app/public /app/public/storage

COPY docker/start-container.sh /usr/local/bin/start-container
RUN chmod +x /usr/local/bin/start-container

EXPOSE 80

ENTRYPOINT ["start-container"]
