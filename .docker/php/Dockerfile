ARG PHP_VERSION

FROM composer@sha256:af98f42dfff7c68ba8d53c2164fd9fde1087b7d449514baa38c418b1f6bc4bac
FROM php:${PHP_VERSION}-fpm-alpine

ARG USER_ID=1000
ARG WITH_XDEBUG=false
ARG GITHUB_TOKEN

COPY --from=composer@sha256:af98f42dfff7c68ba8d53c2164fd9fde1087b7d449514baa38c418b1f6bc4bac /usr/bin/composer /usr/local/bin/composer

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
