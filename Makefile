build:
	cp .env.example src/.env
	docker compose down -v
	docker compose build --no-cache
	docker compose up -d