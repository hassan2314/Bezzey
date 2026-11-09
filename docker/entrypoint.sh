#!/bin/sh
set -eu

cd /var/www/html

mkdir -p storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    database

if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    db_path="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
    mkdir -p "$(dirname "$db_path")"
    if [ ! -f "$db_path" ]; then
        touch "$db_path"
    fi
fi

if [ -z "${APP_KEY:-}" ]; then
    # Keep the generated key in this process only. It is not printed.
    APP_KEY="$(php -r 'echo "base64:".base64_encode(random_bytes(32));')"
    export APP_KEY
fi

php artisan package:discover --ansi
php artisan migrate --force
php artisan db:seed --force

port="${PORT:-8000}"
exec php artisan serve --host=0.0.0.0 --port="$port" --no-reload
