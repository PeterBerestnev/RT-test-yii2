.PHONY: build
build:
	docker-compose build

.PHONY: up
up:
	docker-compose up -d
	docker-compose exec php-fpm composer install
	docker-compose exec mongodb mongosh GoodNews --f ./migrations/init.js 
	docker-compose exec mongodb mongosh GoodNews --f ./migrations/admin.js
	docker-compose exec mongodb mongosh GoodNews --f ./migrations/settings.js 
	docker-compose exec mongodb mongosh GoodNews --f ./migrations/index.js

.PHONY: stop
stop:
	docker-compose stop

.PHONY: rm
rm:
	docker-compose rm

.DEFAULT_GOAL := build