#!/bin/bash
set -e

cd /var/www/html

# Ensure Laravel has an .env file before any Artisan command tries to read it.
if [ ! -f .env ]; then
    touch .env
fi

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Cache config, routes, views for performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
php artisan migrate --force

# Start Apache in foreground
apache2-foreground
