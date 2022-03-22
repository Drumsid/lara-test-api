#запуск докер приложений
build:
	docker-compose up --build -d

#остановка докер приложений
stop:
	docker-compose down

#запуск композера внутри докера
install:
	docker exec -it l-php-fpm composer install

#заходим в bash
bash:
	 docker exec -it l-php-fpm  bash
