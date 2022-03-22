#запуск докер приложений
build:
	docker-compose up --build -d

#остановка докер приложений
stop:
	docker-compose down

#запуск композера внутри докера
install:
	composer install
	cp -n .env.example .env || true
	php artisan key:generate

#заходим в bash
bash:
	 docker exec -it l-php-fpm  bash
