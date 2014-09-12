default: run-unit-tests

.PHONY:
	default \
	run-unit-tests

run-unit-tests:
	phpunit --bootstrap vendor/autoload.php test/
