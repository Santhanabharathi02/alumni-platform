#!/bin/bash
set -e

cd /var/www/html

# Ensure Laravel has an .env file before any Artisan command tries to read it.
if [ ! -f .env ]; then
    touch .env
fi

# Render deployments may use SQLite without pre-creating the database file.
if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    mkdir -p database
    touch database/database.sqlite
fi

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Cache config, routes, views for performance
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Run database migrations
php artisan migrate --force || true

# Start Apache in foreground
apache2-foreground
