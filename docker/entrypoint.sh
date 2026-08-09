#!/bin/sh
set -e

# Cache configuration & routes in production
php artisan storage:link || true
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations automatically
php artisan migrate --force

# Start PHP-FPM in background and Nginx in foreground
php-fpm -D
nginx -g "daemon off;"
