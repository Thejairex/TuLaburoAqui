FROM php:8.4-fpm-alpine

RUN apk add --no-cache \
    postgresql-dev \
    sqlite-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    oniguruma-dev \
    libxml2-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev

RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    pdo_sqlite \
    bcmath \
    ctype \
    exif \
    fileinfo \
    gd \
    mbstring \
    opcache \
    pcntl \
    sockets \
    tokenizer \
    xml \
    zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY . .
RUN composer dump-autoload --optimize

RUN php artisan storage:link

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

COPY docker/php.ini "$PHP_INI_DIR/conf.d/99-tulaburoaqui.ini"

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
