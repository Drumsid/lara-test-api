
## Запуск

`make build`

`make install`

для Windows этого достаточно, на linux нужно добавить права папкам:

 `/storage/logs` и `/storage/frameworks` и `/bootstrap/cache`

Заходим в корень проекта пишем:

`sudo chown -R $USER:$USER .`

`sudo chmod -R 775 .`

`sudo chmod -R 775 storage`

`sudo chmod -R ugo+rw storage`

далее:

`sudo chown -R www-data:www-data ./storage/logs/`

`sudo chown -R www-data:www-data ./storage/framework/`

`sudo chown -R www-data:www-data ./bootstrap/cache`

`sudo chmod -R 775 ./bootstrap/cache`


Проверяем в браузере [localhost:8089](http://localhost:8089/)


## Конфиг Docker
* **php** = 8.0-fpm
* **nginx** = 1.17

