init:
	cp .env.example .env
	sudo sysctl -w vm.max_map_count=262144
	docker-compose build
	make start
	sleep 50
	docker-compose exec php-fpm bash -c "composer install && php artisan key:generate"
	docker-compose exec php-fpm php artisan migrate:fresh --seed

start:
	docker-compose up --build -d

down:
	docker-compose down
