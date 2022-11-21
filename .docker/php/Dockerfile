FROM php:8.1-fpm

ENV NETTE_DEBUG=1
ENV COMPOSER_ALLOW_SUPERUSER=1

COPY . /var/www/html

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions mysqli pdo_mysql @composer

RUN ls

RUN composer install