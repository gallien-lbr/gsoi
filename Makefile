start:
	./dc up -d
stop:
	./dc down
php_shell:
	docker exec -it gsoi_php_1 sh
doctrine_migrate:
	docker exec -it gsoi_php_1 php bin/console d:m:m
