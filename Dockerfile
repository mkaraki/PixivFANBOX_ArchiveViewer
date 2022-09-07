FROM composer AS composer

COPY composer.json /app/composer.json
COPY composer.lock /app/composer.lock

RUN composer install


FROM php:8.1-apache-bullseye

COPY --from=composer /app/vendor /var/www/html/vendor

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN a2enmod rewrite

COPY .htaccess /var/www/html/.htaccess
COPY router.php /var/www/html/router.php
COPY file.php /var/www/html/file.php
COPY view/* /var/www/html/view/
COPY class/* /var/www/html/class/

COPY _config.docker.php /var/www/html/_config.php

VOLUME [ "/var/www/fanbox" ]