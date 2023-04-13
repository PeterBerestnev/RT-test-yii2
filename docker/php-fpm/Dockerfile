FROM php:8.1-fpm

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

# RUN apt-get update && apt-get install -y software-properties-common 
# RUN add-apt-repository ppa:ondrej/php 
# RUN apt-get update && sudo apt install php8.1-mongodb \
# RUN apt-get install php8.1-dom \
# RUN apt-get install php8.1-curl



WORKDIR /var/www

#Эта строка может быть не корректной
COPY ./ ./
RUN cd web && chmod 777 img
RUN  composer install