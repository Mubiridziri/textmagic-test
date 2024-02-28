.PHONY: install
install: ## Composer install feature
	docker run --rm --interactive --tty \
      --volume ./app:/app \
      composer install
.PHONY: phpunit
phpunit: ## Run phpunits
	docker run -it --rm \
	--volume ./app:/app php:8.2-cli \
	php app/vendor/bin/phpunit app/tests 
--configuration=app/phpunit.xml

.PHONY: login
login: ## Log In to PHP container
	docker-compose exec php bash

.PHONY: docker-up
docker-up: ## Start Docker Container (with build)
	docker-compose up --build -d

.PHONY: docker-deploy
docker-deploy: ## Deployment app first time
	docker-compose up --build -d
	docker-compose exec php composer install
	docker-compose exec php sh deploy.sh


.PHONY: db-diff
db-diff: ## Alias of doctrine:migrations:diff
	docker-compose exec php back/bin/console doctrine:migrations:diff

.PHONY: db-diff
db-migrate: ## Alias of doctrine:migrations:migrate -n
	docker-compose exec php back/bin/console doctrine:migrations:migrate -n

.PHONY: docker-logs
docker-logs: ## Show containers logs
	docker-compose logs

.PHONY: help
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.DEFAULT_GOAL := build