# Good News
## Зависимости
* make
* docker v23.0.3
* docker-compose v2.17.2

## Запуск в dev режиме
В корне проекта и в директории ./vuejs нужно использовать 

~~~
cp .env.example .env
~~~

_*При изменениее параметров: 'DB_USER', 'DB_PASS', 'DB_NAME' необходимо заменить соответствующие значения в ./migrations/init.js_
~~~
make
make up
~~~

## Завершение работы
~~~
make stop
make rm
~~~

## Вход в панель администратора
* URL: http://localhost/admin
* Логин: Peter
* Пароль: qwe123

## Примечания

_*Пагинатор появляется когда число страниц больше одной_

_*При работе в административной панели не забывайте нажимать "Сохранить", в противном случае изменения не будут внесены_

## Ссылки
[Документация API](docs/api.md)
