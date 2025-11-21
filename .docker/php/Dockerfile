ARG PHP_VERSION

FROM composer@sha256:ea704a565cd41c2c6f6910def509cb8944096a81e4a46cb02f827063c216363f
FROM php:${PHP_VERSION}-fpm-alpine

ARG USER_ID=1000
ARG WITH_XDEBUG=false
ARG GITHUB_TOKEN

COPY --from=composer@sha256:ea704a565cd41c2c6f6910def509cb8944096a81e4a46cb02f827063c216363f /usr/bin/composer /usr/local/bin/composer

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
