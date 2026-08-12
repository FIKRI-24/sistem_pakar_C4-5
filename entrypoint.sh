#!/bin/sh
set -e

# Laravel environment setup
cd /var/www/html/karir-siswa

# Copy env if not exists
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Set SQLite database environment variables dynamically
sed -i 's/^DB_CONNECTION=.*/DB_CONNECTION=sqlite/' .env
sed -i 's/^DB_DATABASE=.*/DB_DATABASE=\/var\/www\/html\/karir-siswa\/database\/database.sqlite/' .env
# Remove MySQL host/port config that might interfere
sed -i 's/^DB_HOST=.*/# DB_HOST=/' .env
sed -i 's/^DB_PORT=.*/# DB_PORT=/' .env
sed -i 's/^DB_USERNAME=.*/# DB_USERNAME=/' .env
sed -i 's/^DB_PASSWORD=.*/# DB_PASSWORD=/' .env

# Set python C4.5 service URL to local container
sed -i 's/^C45_SERVICE_URL=.*/C45_SERVICE_URL=http:\/\/127.0.0.1:8001/' .env

# Generate APP_KEY if not already set
if ! grep -q "APP_KEY=base" .env; then
    php artisan key:generate --force
fi

# Ensure SQLite file exists and has correct ownership/permissions
mkdir -p database
touch database/database.sqlite
chmod -R 775 database
chown -R www-data:www-data database

# Run migrations if database is empty/new
if [ ! -s database/database.sqlite ]; then
    echo "First boot: Seeding and running migrations..."
    php artisan migrate --force
    php artisan db:seed --force
fi

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions for storage/bootstrap/cache
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Build C4.5 FastAPI .env if not exists
cd /var/www/html/c45-service
if [ ! -f .env ]; then
    cat <<EOT > .env
C45_DB_CONNECTION=sqlite
C45_DB_DATABASE=/var/www/html/karir-siswa/database/database.sqlite
C45_HOST=127.0.0.1
C45_PORT=8001
C45_ENVIRONMENT=production
EOT
fi

# Start supervisord
echo "Starting services..."
exec supervisord -c /etc/supervisor/conf.d/supervisord.conf
