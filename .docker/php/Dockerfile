ARG PHP_VERSION

FROM composer@sha256:8f3b7d97cd7436dae41d6af0dd6a53853779040ecac26e65544fc31746035705
FROM php:${PHP_VERSION}-fpm-alpine

ARG USER_ID=1000
ARG WITH_XDEBUG=false
ARG GITHUB_TOKEN

COPY --from=composer@sha256:8f3b7d97cd7436dae41d6af0dd6a53853779040ecac26e65544fc31746035705 /usr/bin/composer /usr/local/bin/composer

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
