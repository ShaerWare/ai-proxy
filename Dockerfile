# Stage 1: Установка зависимостей
FROM composer:2 as vendor

WORKDIR /app
COPY database/ database/
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist


# Stage 2: Сборка финального образа
FROM php:8.2-fpm-alpine

# Устанавливаем системные зависимости
RUN apk add --no-cache \
    nginx \
    supervisor \
    libzip-dev \
    postgresql-dev \ # Для работы с PostgreSQL
    oniguruma-dev \
    libxml2-dev

# Устанавливаем расширения PHP
RUN docker-php-ext-install \
    pdo_pgsql \ # Драйвер PostgreSQL
    pgsql \
    zip \
    mbstring \
    exif \
    pcntl \
    bcmath \
    sockets \
    opcache

# Копируем код приложения
WORKDIR /var/www
COPY . .

# Копируем установленные зависимости из первого этапа
COPY --from=vendor /app/vendor/ /var/www/vendor/

# Настраиваем права доступа для Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
    chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Копируем конфигурацию Nginx и Supervisor
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Открываем порт
EXPOSE 80

# Запускаем Supervisor, который будет управлять Nginx и PHP-FPM
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]