DOCKER_PHP_SERVICE = php-fpm

.PHONY: new composer-install composer-update up kill test

new: kill
	docker compose up -d --build --remove-orphans
	make composer-install

composer-install:
	docker compose exec $(DOCKER_PHP_SERVICE) composer install --optimize-autoloader

composer-update:
	docker compose exec $(DOCKER_PHP_SERVICE) composer update --lock

test:
	docker compose exec $(DOCKER_PHP_SERVICE) composer test

up:
	docker compose up -d

kill:
	docker compose kill
	docker compose down --volumes --remove-orphans
