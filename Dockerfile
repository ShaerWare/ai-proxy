# Stage 1: Build stage with dependencies
FROM composer:2 as vendor

WORKDIR /app
COPY . .
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Stage 2: Production stage
FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# Install system dependencies
RUN apk --no-cache add \
    nginx \
    supervisor

# Copy application files
COPY --from=vendor /app .
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/supervisord.conf /etc/supervisord.conf

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port
EXPOSE 80

# Run supervisord
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]