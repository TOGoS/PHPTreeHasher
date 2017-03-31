default: run-unit-tests

clean:
	rm -rf composer.lock vendor

.PHONY:
	clean \
	default \
	run-unit-tests

vendor: composer.json
	composer install
	touch "$@"

run-unit-tests: vendor
	vendor/bin/phpunit --bootstrap vendor/autoload.php test/
