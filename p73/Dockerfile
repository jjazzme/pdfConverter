FROM php:7.3.26-fpm-alpine3.13
WORKDIR /var/www/html
RUN apk add --no-cache \
    autoconf \
    make \
    gcc \
    g++ \
    freetype-dev \
    imagemagick-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libxml2-dev \
    imagemagick \
    freetype \
    libjpeg-turbo \
    libpng \
    libxml2 \
    libzip \
    libreoffice \
    ttf-linux-libertine \
    supervisor \
    nginx && \
pecl install imagick && \
docker-php-ext-configure gd \
    --with-gd \
    --with-freetype-dir=/usr/include/ \
    --with-png-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ && \
docker-php-ext-install \
    gd \
    iconv
RUN apk --no-cache add msttcorefonts-installer fontconfig && \
    update-ms-fonts && \
    fc-cache -f
RUN echo "extension=imagick.so" > /usr/local/etc/php/conf.d/pecl-imagick.ini


RUN chown www-data:www-data /tmp
