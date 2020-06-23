FROM php:7.4.7-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -i 's/ServerSignature On/ServerSignature Off/g' /etc/apache2/conf-enabled/security.conf
RUN sed -i 's/ServerTokens OS/ServerTokens Prod/g' /etc/apache2/conf-enabled/security.conf

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
        libxml2-dev \
    && docker-php-ext-install -j$(nproc) xml soap pdo pdo_mysql

COPY docker/php/php.ini /usr/local/etc/php/

COPY docker/apache/default.conf /etc/apache2/sites-available/000-default.conf
