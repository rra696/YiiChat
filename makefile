restart: down up
up:
	docker-compose up -d
down:
	docker-compose down
open_bash:
	docker exec -it yiichat-php-cli bash