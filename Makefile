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
phpstan:
	docker exec -it swapi-starships-app-1 vendor/bin/phpstan analyse -c phpstan.dist.neon
cs:
	docker exec -it swapi-starships-app-1 vendor/bin/php-cs-fixer fix src
cs-check:
	docker exec -it swapi-starships-app-1 vendor/bin/php-cs-fixer check src