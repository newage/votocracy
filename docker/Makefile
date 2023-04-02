include .env

# HELP
# This will output the help for each task
# thanks to https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
.PHONY: help

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help


# DOCKER TASKS
build: ## Build project
	cp .env.example .env
	docker-compose build

init: ## Init project. Install composer
	docker exec -it mezzio_php composer install
	cp ../.env.example ../.env

up: ## Start docker containers
	docker-compose up -d

down: ## Down docker containers. Stop & remove containers
	docker-compose down

stop: ## Stop running containers
	docker-compose stop

start: ## Start existing containers
	docker-compose start

console: ## Connect to container
	docker exec -it mezzio_php bash

deploy-swagger: ## Deploy swagger documentation
	docker exec -it mezzio_php composer swagger:deploy

run-api-tests: ## Run all api tests
	docker exec -it mezzio_php vendor/bin/behat