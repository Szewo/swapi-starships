up:
	docker compose up -d
build:
	docker compose build
down:
	docker compose down
run-web-container:
	docker exec -it swapi-starships-app-1 sh
build-with-xdebug:
	docker compose --env-file .env.debug up --build -d
debug-mode:
	XDEBUG_MODE=debug docker compose up -d
coverage-mode:
	XDEBUG_MODE=coverage docker compose up -d
phpstan:
	docker exec -it swapi-starships-app-1 vendor/bin/phpstan analyse -c phpstan.dist.neon
cs:
	docker exec -it swapi-starships-app-1 vendor/bin/php-cs-fixer fix src
cs-check:
	docker exec -it swapi-starships-app-1 vendor/bin/php-cs-fixer check src
unit:
	docker exec -it swapi-starships-app-1 php bin/phpunit --testdox
unit-coverage:
	XDEBUG_MODE=coverage docker exec -it swapi-starships-app-1 php -d memory_limit=-1 bin/phpunit --testdox --coverage-html ./tmp/coverage