#!/bin/sh
set -e

# Replace PORT in Nginx config if PORT env is set by Render
PORT="${PORT:-80}"
sed -i "s/listen 80;/listen ${PORT};/g" /etc/nginx/http.d/default.conf 2>/dev/null || true

# Run storage link if missing
php artisan storage:link || true

# Run migrations and seeds
php artisan migrate --force || true
php artisan db:seed --force || true

# Cache configuration, routes, and views
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Start PHP-FPM daemon
php-fpm -D

# Exec Nginx in foreground
exec nginx -g "daemon off;"
