build:
	@docker-compose up build && docker exec -it laravel-bet_php bash -c "cd /var/www/laravel-bet && composer install && cp .env.example .env"

run:
	@docker-compose up -d && docker exec -it laravel-bet_php bash -c "php artisan optimize:clear"

stop:
	@docker-compose down

restart:
	@make stop && make run
