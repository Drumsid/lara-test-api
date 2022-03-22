
## Запуск

`make build`

Добавляем права при необходимоста на папку `storage`, описание в разделе `Возможные проблемы`

Проверяем в браузере [localhost:8077](http://localhost:8077/)


## Конфиг
* **php** = 8.0-fpm 
* **nginx** = 1.17


## Возможные проблемы

Проблемы с Laravel с доступом `/storage/logs` или `/storage/frameworks`, добавляем на эти папки права:
Заходим в корень проекта пишем:
`sudo chmod -R 775 storage`
`sudo chmod -R ugo+rw storage`

далее:

`sudo chown -R www-data:www-data ./storage/logs/`
`sudo chown -R www-data:www-data ./storage/framework/`
`sudo chown -R www-data:www-data ./bootstrap/cache`
`sudo chmod -R 775 ./bootstrap/cache`

