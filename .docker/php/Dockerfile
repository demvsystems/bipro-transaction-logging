FROM php:8.3.32-fpm-alpine@sha256:9fcec48321d890240d700ccdc2b475420c87d398826e68c3d8830b8fca663e5c

ARG USER_ID=1000
ARG GITHUB_TOKEN

COPY --from=composer:2.11.2@sha256:5bcb28b8d0edc4091125f8218f9d088f998bdfc843f8fbb9a4beb4dcd8625684 /usr/bin/composer /usr/local/bin/composer

RUN apk update && \
    apk add --no-cache ca-certificates git shadow bash && \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS icu-dev linux-headers && \
    pecl install xdebug && \
    docker-php-ext-enable opcache xdebug && \
    apk del .build-deps

WORKDIR .
ADD . .

RUN usermod -u $USER_ID www-data && chown -R www-data:www-data /var/www/ .

USER www-data
RUN composer config -g github-oauth.github.com $GITHUB_TOKEN

CMD ["php-fpm"]
