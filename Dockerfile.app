# Base Image
FROM php:8.3-fpm

# Build Arguments
ARG WORKDIR=/var/www/html
ARG GROUP_ID=1000
ARG USER_ID=1000
ARG GROUP_NAME=www-data
ENV USER_NAME=www-data
ENV LARAVEL_PROCS_NUMBER=1
ENV NODE_MAJOR=20

# Set Working Directory
WORKDIR $WORKDIR

# Copy Composer Files
COPY composer.lock composer.json $WORKDIR/

# Install System Dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmemcached-dev \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    librdkafka-dev \
    libpq-dev \
    openssh-server \
    zip \
    unzip \
    supervisor \
    sqlite3  \
    nano \
    cron && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP Extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install zip mbstring exif pcntl bcmath -j$(nproc) gd intl && \
    pecl install memcached && docker-php-ext-enable memcached && \
    docker-php-ext-install pdo_mysql pdo_pgsql opcache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy Application Files
COPY . $WORKDIR
COPY docker/php/php.ini $PHP_INI_DIR/conf.d/
COPY docker/php/opcache.ini $PHP_INI_DIR/conf.d/
COPY docker/supervisord/supervisord.conf /etc/supervisor/supervisord.conf
COPY entrypoint.sh /usr/local/bin/
COPY ./.env.example ./.env

# Set Permissions and Ownership
RUN chmod +x /usr/local/bin/entrypoint.sh && \
    usermod -u ${USER_ID} ${USER_NAME} && \
    groupmod -g ${GROUP_ID} ${GROUP_NAME} && \
    chown -R ${USER_NAME}:${GROUP_NAME} /var/www && \
    chown -R ${USER_NAME}:${GROUP_NAME} /var/log/ && \
    chown -R ${USER_NAME}:${GROUP_NAME} /etc/supervisor/conf.d/ && \
    chown -R ${USER_NAME}:${GROUP_NAME} $PHP_INI_DIR/conf.d/ && \
    chown -R ${USER_NAME}:${GROUP_NAME} /tmp && \
    chmod -Rvc 777 $WORKDIR/storage && \
    chmod -Rvc 777 $WORKDIR/bootstrap/cache

# Switch to www-data User
USER www-data

# Expose Port
EXPOSE 9000

# Define Entrypoint and Command
ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
