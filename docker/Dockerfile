FROM php:7.4-alpine3.13

COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install -j$(nproc) pdo_mysql

RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS} \
  && pecl install xdebug \
  && docker-php-ext-enable xdebug \
  && apk del pcre-dev ${PHPIZE_DEPS}

COPY ./php/php.ini /usr/local/etc/php/php.ini

WORKDIR /app

EXPOSE 8000

CMD ["./entrypoint.sh"]
