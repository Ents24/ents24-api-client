default: build
build: phpcs phpunit

phpcs: vendor
	./vendor/bin/phpcs --standard=PSR2 --error-severity=1 src
	./vendor/bin/phpcs --standard=PSR2 --error-severity=1 tests

phpunit: vendor
	./vendor/bin/phpunit

vendor:
	php composer.phar install --dev

.PHONY: build default phpcs phpunit
