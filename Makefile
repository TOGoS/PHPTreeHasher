default: run-unit-tests

.PHONY:
	default \
	run-unit-tests

vendor: composer.json
	composer install
	touch "$@"

run-unit-tests: vendor
	phpunit --bootstrap vendor/autoload.php test/
