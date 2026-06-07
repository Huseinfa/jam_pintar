FROM node:22-bookworm-slim AS frontend

WORKDIR /app

COPY package*.json vite.config.js ./
COPY resources ./resources
COPY public ./public

RUN npm ci && npm run build

FROM php:8.3-cli

# System dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libxml2-dev \
    libonig-dev \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install \
    gd \
    zip \
    mbstring \
    xml \
    pdo_mysql

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Application directory
WORKDIR /app

# Install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Copy project files and built frontend assets
COPY . .
COPY --from=frontend /app/public/build ./public/build

RUN composer dump-autoload --no-dev --optimize \
    && php artisan package:discover --ansi \
    && mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache


# Railway start command
CMD ["sh", "-c", "php artisan config:clear && php artisan route:clear && php artisan view:clear && for i in $(seq 1 10); do php artisan migrate --force && break; if [ \"$i\" -eq 10 ]; then exit 1; fi; echo 'Waiting for database...'; sleep 3; done && php artisan serve --host=0.0.0.0 --port=${PORT:-8000}"]
