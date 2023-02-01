DOCKER_PHP_SERVICE = php-fpm

.PHONY: docker-new docker-composer docker-up docker-kill docker-test

docker-new: docker-kill
	docker-compose up -d --build --remove-orphans
	make docker-composer-install

docker-composer-install:
	docker-compose exec $(DOCKER_PHP_SERVICE) composer install --optimize-autoloader

docker-composer-update:
	docker-compose exec $(DOCKER_PHP_SERVICE) composer update --lock

docker-test:
	docker-compose exec $(DOCKER_PHP_SERVICE) composer test

docker-up:
	docker-compose up -d

docker-kill:
	docker-compose kill
	docker-compose down --volumes --remove-orphans
