lint:
	./vendor/bin/phpstan analyse --memory-limit=2G

test:
	./vendor/bin/pest

test-coverage:
	./vendor/bin/sail artisan test --coverage

clear-all:
	./vendor/bin/sail artisan optimize:clear
