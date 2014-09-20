default: build
build: phpcs phpunit

phpcs: vendor
	./vendor/bin/phpcs --standard=PSR2 --error-severity=1 src
	./vendor/bin/phpcs --standard=PSR2 --error-severity=1 tests

phpunit: vendor
	./vendor/bin/phpunit

vendor:
	composer install --dev

.PHONY: build default phpcs phpunit
