.PHONY: build
build:
	cd ./vuejs && npm install
	composer install
	docker-compose build

.PHONY: up
up:
	docker-compose up

.PHONY: stop
stop:
	docker-compose stop

.PHONY: rm
rm:
	docker-compose rm

.PHONY: prepare
prepare:
	docker-compose exec mongodb mongosh my_database --f ./migrations/init.js
	docker-compose exec mongodb mongosh my_database --f ./migrations/admin.js

.DEFAULT_GOAL := build