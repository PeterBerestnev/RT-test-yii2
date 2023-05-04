.PHONY: build
build:
	docker-compose build

.PHONY: up
up:
	docker-compose up -d
	docker-compose exec php-fpm composer install
	docker-compose exec mongodb mongosh my_database --f ./migrations/init.js 
	docker-compose exec mongodb mongosh my_database --f ./migrations/admin.js

.PHONY: stop
stop:
	docker-compose stop

.PHONY: rm
rm:
	docker-compose rm

.DEFAULT_GOAL := build