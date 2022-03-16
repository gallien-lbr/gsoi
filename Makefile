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
build:
	 docker-compose up -d --no-deps --build

# APP TESTING
test:
	docker exec -it gsoi_php_1 vendor/bin/phpunit
test_create_db:
	docker exec -it gsoi_php_1 php bin/console doctrine:database:create --env=test
test_migrate_db:
	docker exec -it gsoi_php_1 php bin/console doctrine:migrations:migrate -n --env=test
test_with_coverage:
	docker exec -it gsoi_php_1 vendor/bin/phpunit --coverage-html coverage
test_api_endpoint:
	docker exec -it gsoi_php_1 vendor/bin/phpunit tests/Controller/LinkControllerTest.php


