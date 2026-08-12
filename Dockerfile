# Stage 1: Build Laravel Vite Assets
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY ./karir-siswa /app
RUN npm install
RUN npm run build

# Stage 2: Main Production Image
FROM php:8.2-fpm-bookworm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    supervisor \
    python3 \
    python3-pip \
    python3-venv \
    sqlite3 \
    libsqlite3-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    git \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install zip gd pdo pdo_mysql pdo_sqlite

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Copy compiled assets from Stage 1
COPY --from=node-builder /app/public/build /var/www/html/karir-siswa/public/build

# Set up Laravel environment
WORKDIR /var/www/html/karir-siswa
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN cp .env.example .env

# Set up permissions for SQLite and Laravel directories
RUN mkdir -p database && touch database/database.sqlite
RUN chown -R www-data:www-data /var/www/html/karir-siswa/storage /var/www/html/karir-siswa/bootstrap/cache /var/www/html/karir-siswa/database

# Set up Python FastAPI environment
WORKDIR /var/www/html/c45-service
RUN python3 -m venv .venv
RUN .venv/bin/pip install --upgrade pip
RUN .venv/bin/pip install .

# Setup Nginx configuration
COPY ./nginx.conf /etc/nginx/sites-available/default

# Setup Supervisor configuration
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Setup Entrypoint
COPY ./entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Revert to root dir
WORKDIR /var/www/html

EXPOSE 80

ENTRYPOINT ["entrypoint.sh"]
