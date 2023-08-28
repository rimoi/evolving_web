include .env

#---VARIABLES---------------------------------#
#---DOCKER---#
DOCKER = docker
DOCKER_RUN = $(DOCKER) run
DOCKER_COMPOSE = docker-compose
DOCKER_COMPOSE_UP = $(DOCKER_COMPOSE) up -d --build
DOCKER_COMPOSE_START = $(DOCKER_COMPOSE) up -d
DOCKER_COMPOSE_STOP = $(DOCKER_COMPOSE) stop
#------------#

FIG=docker-compose -f docker-compose.yml -f docker-compose.$(INFRA_ENV).yml
EXEC = $(FIG) exec php

## === 🆘  HELP ==================================================
help: ## Affiche cette aide.
	@echo "Carizy Project"
	@echo "---------------------------"
	@echo "Utilisation: make [target]"
	@echo ""
	@echo "Cibles:"
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
#---------------------------------------------#


## === TEERAFORM ================================================
init-dev:
	cd terraform && terraform init -migrate-state \-backend-config="bucket=${S3_BUCKET_NAME}" \-backend-config="region=${AWS_DEFAULT_REGION}"
	
plan-dev:
	cd terraform && terraform plan
apply-dev:
	cd terraform && terraform apply -auto-approve

output-dev:
	cd terraform && terraform output >>  ../scripts/output.env 
	
destroy-dev:
	cd terraform && terraform destroy -auto-approve
#---------------------------------------------#


## === 🐋  DOCKER ================================================
reset: start vendor dsv cc perm ## Lance le projet.
.PHONY: reset

start: ## Lance le projet.
	$(DOCKER_COMPOSE_UP)
.PHONY: start

up: ## Lance le projet.
	$(DOCKER_COMPOSE_UP)
.PHONY: up

stop: ## Arrête le projet.
	$(DOCKER_COMPOSE_STOP)
.PHONY: stop
#---------------------------------------------#

## === 🐘  Docker PHP ================================================
vendor: ## Installe le projet.
	$(EXEC) composer install
.PHONY: vendor

tty: ## Se connecter au conteneur PHP
	$(DOCKER_COMPOSE) exec php /bin/bash
.PHONY: tty
#---------------------------------------------#

## === 🐬  Docker Mysql ================================================
db-tty: ## Se connecter au conteneur MySQL
	$(DOCKER_COMPOSE) exec database /bin/bash
.PHONY: db-tty

d-d-d: ## Drop database
	$(DOCKER_COMPOSE) exec php bin/console d:d:d -f
.PHONY: d-d-d

d-d-c: ## Create database
	$(DOCKER_COMPOSE) exec php bin/console d:d:c
.PHONY: d-d-c

dsv: ## Create database
	$(DOCKER_COMPOSE) exec php bin/console doctrine:schema:validate
.PHONY: dsv
#---------------------------------------------#

cc:
	$(DOCKER_COMPOSE) exec php bin/console cache:clear --no-warmup
	$(DOCKER_COMPOSE) exec php bin/console cache:warmup
.PHONY: cc

perm:
	-$(EXEC) chmod -R 777 var
.PHONY: perm

#---------------------------------------------#

## === 🧹  PSR ================================================

phpcs-dry:
	$(DOCKER_COMPOSE) exec php vendor/bin/php-cs-fixer fix --config .php-cs-fixer.dist.php --using-cache=no --allow-risky=yes --dry-run
	#$(DOCKER_COMPOSE) exec php tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --config .php-cs-fixer.dist.php --using-cache=no --allow-risky=yes --dry-run
.PHONY: phpcs-dry

phpcs-fix:
	$(DOCKER_COMPOSE) exec php vendor/bin/php-cs-fixer fix --config .php-cs-fixer.dist.php --using-cache=no --allow-risky=yes
	#$(DOCKER_COMPOSE) exec php tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --config .php-cs-fixer.dist.php --using-cache=no --allow-risky=yes
.PHONY: phpcs-fix

### PHP_CodeSniffer ###
sniffer:
	$(DOCKER_COMPOSE) exec php ./vendor/bin/phpcs
.PHONY: phpcs-dry

sniffer-fix:
	$(DOCKER_COMPOSE) exec php ./vendor/bin/phpcbf
.PHONY: phpcs-fix