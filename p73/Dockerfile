FROM php:7.3.26-fpm-alpine3.13
WORKDIR /var/www/html
RUN apk add --no-cache \
    libreoffice \
    ttf-freefont \
    supervisor \
    nginx
RUN chown www-data:www-data /tmp
