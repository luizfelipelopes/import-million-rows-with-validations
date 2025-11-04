build:
	cp .env.example src/.env
	docker compose down -v
	docker compose up -d --build