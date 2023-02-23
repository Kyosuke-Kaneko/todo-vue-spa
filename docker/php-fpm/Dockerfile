FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
        zlib1g-dev \
        libzip-dev \
        libpng-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpq-dev \
        git \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo pdo_mysql opcache

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

COPY www.conf /etc/php-fpm.d/www.conf
COPY php.ini /usr/local/etc/php
COPY opcache.ini /usr/local/etc/php/conf.d/opcache.ini