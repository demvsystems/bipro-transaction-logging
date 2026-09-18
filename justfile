docker_php_service := "php-fpm"

[private]
default:
    @just --list

new: kill
    docker compose up -d --build --remove-orphans
    just composer-install

composer-install:
    docker compose exec {{docker_php_service}} composer install --optimize-autoloader

composer-update:
    docker compose exec {{docker_php_service}} composer update --lock

test:
    docker compose exec {{docker_php_service}} composer test

up:
    docker compose up -d

kill:
    docker compose kill
    docker compose down --volumes --remove-orphans
