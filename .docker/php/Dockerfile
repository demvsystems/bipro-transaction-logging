ARG PHP_VERSION

FROM composer@sha256:5248900ab8b5f7f880c2d62180e40960cd87f60149ec9a1abfd62ac72a02577c
FROM php:${PHP_VERSION}-fpm-alpine

ARG USER_ID=1000
ARG WITH_XDEBUG=false
ARG GITHUB_TOKEN

COPY --from=composer@sha256:5248900ab8b5f7f880c2d62180e40960cd87f60149ec9a1abfd62ac72a02577c /usr/bin/composer /usr/local/bin/composer

RUN apk update && \
    apk add --no-cache ca-certificates git shadow bash && \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS icu-dev && \
    docker-php-ext-enable opcache

RUN if [ ${WITH_XDEBUG} = true ]; then \
    pecl install xdebug && docker-php-ext-enable xdebug \
    # Copy xdebug configuration for remote debugging
;fi

RUN apk del .build-deps

WORKDIR .
ADD . .

RUN usermod -u $USER_ID www-data && chown -R www-data:www-data /var/www/ .

USER www-data
RUN composer config -g github-oauth.github.com $GITHUB_TOKEN

CMD ["php-fpm"]
