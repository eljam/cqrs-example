.DEFAULT_GOAL := help
.SILENT:
.PHONY: vendor

dc=docker-compose

## Colors
COLOR_RESET   = \033[0m
COLOR_INFO    = \033[32m
COLOR_COMMENT = \033[33m

## Help
help:
	printf "${COLOR_COMMENT}Usage:${COLOR_RESET}\n"
	printf " make [target]\n\n"
	printf "${COLOR_COMMENT}Available targets:${COLOR_RESET}\n"
	awk '/^[a-zA-Z\-\_0-9\.@]+:/ { \
		helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			printf " ${COLOR_INFO}%-16s${COLOR_RESET} %s\n", helpCommand, helpMessage; \
		} \
	} \
{ lastLine = $$0 }' $(MAKEFILE_LIST)

##################
# Useful targets #
##################

## Install all install_* requirements and launch project.
install: env_run install_env install_vendor install_db fixtures

## Run the stack
up: env_run

## Stop the stack
stop: env_stop

## Restart the stack
restart: env_stop env_run

## Run all quality assurance tools (tests and code inspection).
qa: code_static_analysis code_fixer code_detect code_correct test

## Truncate database and import fixtures.
fixtures:
	php vendor/bin/console doc:fix:load

## Clean the all stack
clean:
	make stop
	$(dc) down -v --remove-orphans
	$(dc) rm

## Open logs
log:
	symfony server:log

###############
# Environment #
###############

## Launch docker environment.
env_run:
	$(dc) up --build --remove-orphans -d
	symfony proxy:start
	symfony serve -d

env_stop:
	symfony server:stop
	symfony proxy:stop
	$(dc) stop

###########
# Install #
###########

install_env:
	symfony server:ca:install
	symfony proxy:domain:attach cqrs.com

## Run database migration.
install_db:
	php vendor/bin/console do:sch:cr

## Install vendors.
install_vendor:
	composer install --prefer-dist --no-scripts --no-progress --no-suggest

########
# Code #
########

## Run codesniffer to correct violations of a defined coding project standards.
code_correct:
	php vendor/bin/phpcs --standard=PSR2 src

## Run codesniffer to detect violations of a defined coding project standards.
code_detect:
	php vendor/bin/phpcbf --standard=PSR2 src tests

## Run cs-fixer to fix php code to follow project standards.
code_fixer:
	php vendor/bin/php-cs-fixer fix

## Run PHPStan to find errors in code.
code_static_analysis:
	php vendor/bin/phpstan analyse src --level 5

########
# Test#
########

## Run unit&integration tests with pre-installing test database.
test: test_unit

## Run unit&integration tests.
test_unit:
	php vendor/bin/simple-phpunit
