start:
	./dc up -d
stop:
	./dc down
php:
	docker exec -it gsoi_php_1 sh
doctrine_migrate:
	docker exec -it gsoi_php_1 php bin/console d:m:m
doctrine_gen_migration:
	docker exec -it gsoi_php_1 php bin/console doctrine:migrations:dump-schema
test:
	docker exec -it gsoi_php_1 vendor/bin/phpunit
coverage:
	docker exec -it gsoi_php_1 vendor/bin/phpunit --coverage-html coverage
build:
	 docker-compose up -d --no-deps --build