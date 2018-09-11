include .env

.PHONY: up start down stop prune ps shell logs install update console clear-cache phpunit

default: up

up:
	@echo "Starting up containers for for $(PROJECT_NAME)..."
	docker-compose pull
	docker-compose up -d --remove-orphans

start:
	@echo "Continue where you left off with $(PROJECT_NAME)..."
	docker-compose start

down: stop

stop:
	@echo "Stopping containers for $(PROJECT_NAME)..."
	@docker-compose stop

prune:
	@echo "Removing containers for $(PROJECT_NAME)..."
	@docker-compose down -v

ps:
	@docker ps --filter name='$(PROJECT_NAME)*'

shell:
	docker exec -ti -e COLUMNS=$(shell tput cols) -e LINES=$(shell tput lines) $(shell docker ps --filter name='$(PROJECT_NAME)_$(filter-out $@,$(MAKECMDGOALS))' --format "{{ .ID }}") sh

logs:
	@docker-compose logs -f $(filter-out $@,$(MAKECMDGOALS))

# Project specific commands:

install:
	@echo "Install dependencies for $(PROJECT_NAME)..."
	@docker exec -ti -e COLUMNS=$(shell tput cols) -e LINES=$(shell tput lines) $(shell docker ps --filter name='$(PROJECT_NAME)_php' --format "{{ .ID }}") sh -c "composer install --no-progress --no-interaction --no-suggest"

update:
	@echo "Update dependencies for $(PROJECT_NAME)..."
	@docker exec -ti -e COLUMNS=$(shell tput cols) -e LINES=$(shell tput lines) $(shell docker ps --filter name='$(PROJECT_NAME)_php' --format "{{ .ID }}") sh -c "composer update --no-progress --no-interaction --with-all-dependencies"

console:
	@docker exec -ti -e COLUMNS=$(shell tput cols) -e LINES=$(shell tput lines) $(shell docker ps --filter name='$(PROJECT_NAME)_php' --format "{{ .ID }}") sh -c "bin/console $(filter-out $@,$(MAKECMDGOALS))"

cache-clear:
	@docker exec -ti -e COLUMNS=$(shell tput cols) -e LINES=$(shell tput lines) $(shell docker ps --filter name='$(PROJECT_NAME)_php' --format "{{ .ID }}") sh -c "bin/console cache:clear"

phpunit:
	@docker exec -ti -e COLUMNS=$(shell tput cols) -e LINES=$(shell tput lines) $(shell docker ps --filter name='$(PROJECT_NAME)_php' --format "{{ .ID }}") sh -c "vendor/bin/phpunit"

# https://stackoverflow.com/a/6273809/1826109
%:
	@:
