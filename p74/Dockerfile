FROM php:7.3.26-fpm-alpine3.13
WORKDIR /var/www/html

RUN apk add --no-cache \
    libzip-dev \
    nginx \
    autoconf \
    gcc \
    g++ \
    make \
    && docker-php-ext-install zip\


RUN chown www-data:www-data /tmp

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
