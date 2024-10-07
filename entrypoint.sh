#!/bin/bash

echo ""
echo "***********************************************************"
echo "   Starting LARAVEL PHP-FPM Container                      "
echo "***********************************************************"

set -e

info() {
    { set +x; } 2> /dev/null
    echo "$(date '+%Y-%m-%d %H:%M:%S') [INFO] $@"
}
warning() {
    { set +x; } 2> /dev/null
    echo "$(date '+%Y-%m-%d %H:%M:%S') [WARNING] $@"
}
fatal() {
    { set +x; } 2> /dev/null
    echo "$(date '+%Y-%m-%d %H:%M:%S') [ERROR] $@" >&2
    exit 1
}
# Check if environment variables are set
if [ -z "$USER_NAME" ]; then
    fatal "USER_NAME environment variable is not set."
fi

if [ -z "$LARAVEL_PROCS_NUMBER" ]; then
    fatal "LARAVEL_PROCS_NUMBER environment variable is not set."
fi

## Check if the artisan file exists
if [ -f /var/www/html/artisan ]; then
    info "Artisan file found, creating laravel supervisor config..."
    ##Create Laravel Scheduler process
    TASK=/etc/supervisor/conf.d/laravel-worker.conf
    touch $TASK
    cat > "$TASK" <<EOF
[program:Laravel-scheduler]
process_name=%(program_name)s_%(process_num)02d
command=/bin/sh -c "while [ true ]; do (php /var/www/html/artisan schedule:run --verbose --no-interaction &); sleep 60; done"
autostart=true
autorestart=true
numprocs=1
user=$USER_NAME
stdout_logfile=/var/log/laravel_scheduler.out.log
redirect_stderr=true

[program:Laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
numprocs=$LARAVEL_PROCS_NUMBER
user=$USER_NAME
redirect_stderr=true
stdout_logfile=/var/log/laravel_worker.log
EOF
    info "Laravel supervisor config created"
else
    info "Artisan file not found"
fi

## Check if php.ini file exists
if [ -f /var/www/html/conf/php/php.ini ]; then
    if [ -z "$PHP_INI_DIR" ]; then
        fatal "PHP_INI_DIR is not set. Unable to copy php.ini."
    fi
    cp /var/www/html/conf/php/php.ini $PHP_INI_DIR/conf.d/
    info "Custom php.ini file found and copied to $PHP_INI_DIR/conf.d/"
else
    info "Custom php.ini file not found"
    info "If you want to add a custom php.ini file, you can place it in /var/www/html/conf/php/php.ini"
fi

## Run composer install
if [ -f /var/www/html/composer.json ]; then
    info "composer.json file found, running composer install..."
    composer install --no-autoloader --no-scripts
    info "Composer install completed"
else
    info "composer.json file not found"
fi

## Check if APP_KEY is set, if not, generate one
if [ -z "$APP_KEY" ]; then
    info "APP_KEY is not set. Generating a new one..."
    php artisan key:generate --no-interaction
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
fi

# Start supervisord
supervisord -c /etc/supervisor/supervisord.conf
