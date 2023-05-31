FROM php:7.4.33-fpm-alpine3.16
WORKDIR /var/www/html
RUN apk add --no-cache \
    libzip-dev \
    nginx \
    supervisor \
    autoconf \
    gcc \
    g++ \
    make \
    libreoffice \
    ttf-freefont \
    && docker-php-ext-install zip
RUN chown www-data:www-data /tmp
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
