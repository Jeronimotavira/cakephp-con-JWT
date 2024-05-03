#!/bin/bash
APACHE_CNAME = APACHETMZ
help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

start: ## Start the containers
	docker-compose up -d
down: ## down the containers
	docker-compose down
stop: ## Stop the containers
	docker-compose stop

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) start

# Backend commands
composer-install: ## Installs composer dependencies
	docker exec ${APACHE_CNAME} composer install --no-interaction
# End backend commands

ssh-be: ## bash into the be container
	docker exec -it ${APACHE_CNAME} bash

code-style: ## Runs php-cs to fix code styling following Symfony rules
	docker exec ${APACHE_CNAME} php-cs-fixer fix src --rules=@Symfony
