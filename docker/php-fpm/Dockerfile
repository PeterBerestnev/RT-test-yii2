FROM php:7.4-fpm

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


RUN apt-get update \
    && apt-get install -y \
    libzip-dev \ 
    libgd-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    libmagickwand-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && pecl install mongodb \
    && echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini \
    && docker-php-ext-install \
    zip \
    gd \
    exif \
    intl 

WORKDIR /var/www