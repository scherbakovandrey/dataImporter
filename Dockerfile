FROM php:8.1-alpine
COPY . /usr/src/app
WORKDIR /usr/src/app
CMD [ "php", "bin/console", "app:data-import"]
