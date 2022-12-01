FROM php:8.1-alpine

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

COPY . /usr/src/app
WORKDIR /usr/src/app

RUN composer install --no-interaction --prefer-dist

RUN export APP_ENV=prod

CMD ["php", "bin/console", "app:data-import"]