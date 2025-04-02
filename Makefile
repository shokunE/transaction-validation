php:
	docker compose exec backend-php sh
fresh:
	docker compose exec backend-php php artisan migrate:fresh --seed
migrate:
	docker compose exec backend-php php artisan migrate
seed:
	docker compose exec backend-php php artisan db:seed
clear:
	docker compose exec backend-php php artisan optimize:clear