default: run-unit-tests

.PHONY:
	default \
	run-unit-tests

composer.lock: | composer.json
	composer install

vendor/autoload.php: composer.lock
	composer install

run-unit-tests: vendor/autoload.php
	phpunit --bootstrap vendor/autoload.php test/
