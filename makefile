init:
	cp .env.example .env
	docker-compose build
	make start
	docker-compose exec php-fpm bash -c "composer install && php artisan key:generate"
	docker-compose exec php-fpm php artisan migrate:fresh --seed

start:
	docker-compose up --build -d

down:
	docker-compose down
