FROM phpearth/php:7.3-nginx

RUN apk add --no-cache composer \
    && apk add --no-cache php7.3-pdo_mysql


COPY ./app /var/www/html/app
COPY ./public /var/www/html/public
COPY ./composer.json /var/www/html
COPY ./nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/html

RUN composer install -o --apcu-autoloader --dev
