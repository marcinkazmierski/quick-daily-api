FROM php:7.3-apache

COPY php/php.ini /usr/local/etc/php/

# Dependencies
RUN apt-get update

RUN apt-get install -y zip unzip curl openssh-server nano libc-client-dev libkrb5-dev locales locales-all libpng-dev git
RUN docker-php-ext-install pdo pdo_mysql gd sockets

RUN pecl install mongodb \
    &&  echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/mongodb.ini

RUN a2enmod rewrite
RUN service apache2 restart

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN mkdir -p /usr/local/bin
RUN curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
RUN chmod a+x /usr/local/bin/symfony
