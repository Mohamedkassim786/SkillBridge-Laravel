#!/bin/sh
set -e

# Replace PORT in Nginx config if PORT env is set by Render
PORT="${PORT:-80}"
sed -i "s/80;/${PORT};/g" /etc/nginx/http.d/default.conf 2>/dev/null || true

# Start PHP-FPM daemon first so Nginx upstream is active immediately
php-fpm -D

# Run storage link if missing
php artisan storage:link || true

# Run migrations
php artisan migrate --force || true

# Run seeds only if RUN_SEEDERS env var is explicitly set to true
if [ "${RUN_SEEDERS}" = "true" ]; then
    php artisan db:seed --force || true
fi

# Cache configuration, routes, and views
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Re-apply permissions for www-data after running artisan commands
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Exec Nginx in foreground
exec nginx -g "daemon off;"
