FROM php:8.3-cli

# System packages required by Laravel and PhpSpreadsheet
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libxml2-dev \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install \
    gd \
    zip \
    mbstring \
    xml

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# App directory
WORKDIR /app

# Copy application
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel cache optimization (optional but recommended)
RUN php artisan config:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

# Railway provides PORT automatically
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
