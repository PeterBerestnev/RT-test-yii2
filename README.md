# Good News
## Зависимости
* make
* docker v23.0.3
* docker-compose v2.17.2

## Запуск в dev режиме
В файле .env в корне проекта необходимо задать все параметры предоставленные в .env.example
Тоже самое надо сделать с файлом .env в директории ./vuejs
<i>*При изменениее параметров: 'DB_USER', 'DB_PASS', 'DB_NAME' необходимо заменить соответствующие значения в ./migrations/init.js</i>
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

## Документация для API

<h2><strong>Описание</strong></br></h2>
<h3>Это документация для API нашего приложения. Все эндпоинты начинаются с http://localhost:8080/api/.<h3></br>
<h2> Документация для работы с коллекцией 'article'</h2>

<strong>Эндпоинт: </strong>/articles</br>
<strong>Метод: </strong>GET</br>
<strong>Описание:</strong> Получить список статей в коллекции</br>

<strong>Параметры запроса:</strong>
<ul>
  <li>status - статус статей для фильтрации (опционально)</li>
  <li>tags - теги статей для фильтрации (опционально)</li>
  <li>limit - максимальное количество статей в ответе (опционально)</li>
  <li>sort - параметр сортировки (опционально, по умолчанию created_at)</li>
  <li>page - номер страницы (опционально, по умолчанию 1)</li>
  <li>pop - фильтр на просмотры (опционально)</li>
</ul>
<strong>Примеры запросов и ответов:</strong></br></br>

Получить все статьи:
~~~
GET http://localhost:8080/api/articles
~~~

~~~
[
    {
        "status": "Не опубликовано",
        "title": "Пятая статья",
        "_id": "645a528c0d13a19d6f0bf7e2",
        "created_by": "645a45f6158662db9b095963",
        "photo": "1683640972_645a528c27e28.jpg",
        "tags": [
            "sport"
        ],
        "date": 1683640972000,
        "updated_by": "645a45f6158662db9b095963",
        "created_at": 1683640972000,
        "updated_at": 1683641625000
    },
    {
        "status": "Опубликовано",
        "title": "Четвертая статья",
        "_id": "645a526d673bb1d69b0d6008",
        "created_by": "645a45f6158662db9b095963",
        "photo": "1683640941_645a526d134a6.jpg",
        "tags": [
            "sport"
        ],
        "date": 1683640941000,
        "created_at": 1683640941000
    },
    {
        "status": "Опубликовано",
        "title": "Третья статья",
        "_id": "645a5254673bb1d69b0d6007",
        "created_by": "645a45f6158662db9b095963",
        "tags": [
            "sport"
        ],
        "date": 1683640916000,
        "created_at": 1683640916000
    },
    {
        "status": "Опубликовано",
        "title": "Вторая статья",
        "_id": "645a5234673bb1d69b0d6006",
        "created_by": "645a45f6158662db9b095963",
        "photo": "1683640884_645a52349982c.jpg",
        "tags": [
            "sport"
        ],
        "date": 1683640884000,
        "created_at": 1683640884000
    },
    {
        "status": "Опубликовано",
        "title": "AAaaaaaa!",
        "_id": "645a4621673bb1d69b0d6005",
        "created_by": "645a45f6158662db9b095963",
        "tags": [
            "AAaaaaaa"
        ],
        "date": 1683637793000,
        "updated_by": "645a45f6158662db9b095963",
        "created_at": 1683637793000,
        "updated_at": 1683641618000
    }
]
~~~

Получить все статьи со статусом 'Опубликовано':
~~~
GET http://localhost:8080/api/articles?status=Опубликовано
~~~

~~~
[
    {
        "status": "Опубликовано",
        "title": "Четвертая статья",
        "_id": "645a526d673bb1d69b0d6008",
        "created_by": "645a45f6158662db9b095963",
        "photo": "1683640941_645a526d134a6.jpg",
        "tags": [
            "sport"
        ],
        "date": 1683640941000,
        "created_at": 1683640941000
    },
    {
        "status": "Опубликовано",
        "title": "Третья статья",
        "_id": "645a5254673bb1d69b0d6007",
        "created_by": "645a45f6158662db9b095963",
        "tags": [
            "sport"
        ],
        "date": 1683640916000,
        "created_at": 1683640916000
    },
    {
        "status": "Опубликовано",
        "title": "Вторая статья",
        "_id": "645a5234673bb1d69b0d6006",
        "created_by": "645a45f6158662db9b095963",
        "photo": "1683640884_645a52349982c.jpg",
        "tags": [
            "sport"
        ],
        "date": 1683640884000,
        "created_at": 1683640884000
    },
    {
        "status": "Опубликовано",
        "title": "AAaaaaaa!",
        "_id": "645a4621673bb1d69b0d6005",
        "created_by": "645a45f6158662db9b095963",
        "tags": [
            "AAaaaaaa"
        ],
        "date": 1683637793000,
        "updated_by": "645a45f6158662db9b095963",
        "created_at": 1683637793000,
        "updated_at": 1683641618000
    }
]
~~~

Получить первые 3 статьи с тегом sport:
~~~
GET http://localhost:8080/api/articles?tags=sport&limit=3
~~~

~~~
[
    {
        "status": "Не опубликовано",
        "title": "Пятая статья",
        "_id": "645a528c0d13a19d6f0bf7e2",
        "created_by": "645a45f6158662db9b095963",
        "photo": "1683640972_645a528c27e28.jpg",
        "tags": [
            "sport"
        ],
        "date": 1683640972000,
        "updated_by": "645a45f6158662db9b095963",
        "created_at": 1683640972000,
        "updated_at": 1683641625000
    },
    {
        "status": "Опубликовано",
        "title": "Четвертая статья",
        "_id": "645a526d673bb1d69b0d6008",
        "created_by": "645a45f6158662db9b095963",
        "photo": "1683640941_645a526d134a6.jpg",
        "tags": [
            "sport"
        ],
        "date": 1683640941000,
        "created_at": 1683640941000
    },
    {
        "status": "Опубликовано",
        "title": "Третья статья",
        "_id": "645a5254673bb1d69b0d6007",
        "created_by": "645a45f6158662db9b095963",
        "tags": [
            "sport"
        ],
        "date": 1683640916000,
        "created_at": 1683640916000
    }
]
~~~

Получить первые 2 стаьи, отсортированные по дате создания (в обратном порядке):
~~~
GET http://localhost:8080/api/articles?sort=-created_at&limit=2
~~~

~~~
[
    {
        "status": "Не опубликовано",
        "title": "Пятая статья",
        "_id": "645a528c0d13a19d6f0bf7e2",
        "created_by": "645a45f6158662db9b095963",
        "photo": "1683640972_645a528c27e28.jpg",
        "tags": [
            "sport"
        ],
        "date": 1683640972000,
        "updated_by": "645a45f6158662db9b095963",
        "created_at": 1683640972000,
        "updated_at": 1683641625000
    },
    {
        "status": "Опубликовано",
        "title": "Четвертая статья",
        "_id": "645a526d673bb1d69b0d6008",
        "created_by": "645a45f6158662db9b095963",
        "photo": "1683640941_645a526d134a6.jpg",
        "tags": [
            "sport"
        ],
        "date": 1683640941000,
        "created_at": 1683640941000
    }
]
~~~

Получить статьи, опубликованные за последние 24 часа:
~~~
GET http://localhost:8080/api/articles?pop=1
~~~

~~~
[
    {
        "title": "Пятая статья",
        "status": "Не опубликовано",
        "_id": "645a528c0d13a19d6f0bf7e2",
        "views": 1,
        "created_by": "645a45f6158662db9b095963",
        "photo": "1683640972_645a528c27e28.jpg",
        "tags": [
            "sport"
        ],
        "date": 1683640972000,
        "updated_by": "645a45f6158662db9b095963",
        "created_at": 1683640972000,
        "updated_at": 1683641625000
    }
]
~~~
Возможные ошибки:
<ul>
  <li>422 Unprocessable Entity - некорректные параметры запроса или тела запроса</li>
  <li>500 Internal Server Error - ошибка сервера при обновлении статьи</li>
</ul>

---

<strong>Эндпоинт: </strong>/get-count</br>
<strong>Метод: </strong>GET</br>
<strong>Описание:</strong> Возвращает количество статей в коллекции MongoDB, которые соответствуют заданным фильтрам</br>


<strong>Параметры запроса:</strong>
<ul>
  <li>status - статус статей для фильтрации (опционально)</li>
  <li>tags - теги статей для фильтрации (опционально)</li>
  <li>pop - фильтр на просмотры (опционально)</li>
</ul>

Пример запроса и ответа:
~~~
GET http://localhost:8080/api/get-count?status=Опубликовано&tags=tech&pop=true
~~~

~~~
0
~~~
Возможные ошибки:
<ul>
  <li>422 Unprocessable Entity - некорректные параметры запроса или тела запроса</li>
  <li>500 Internal Server Error - ошибка сервера при обновлении статьи</li>
</ul>
</br>

---

<strong>Эндпоинт: </strong>/article</br>
<strong>Метод: </strong>POST</br>
<strong>Описание:</strong> Создает новую статью</br>

<strong>Параметры запроса:</strong>
<ul>
  <li>title - заголовок статьи (обязательный)</li>
  <li>photo - фото</li>
  <li>text - основной текст статьи</li>
  <li>status - Статус статьи (опубликовано/Не опубликовано)</li>
  <li>tags - теги статьи</li>
</ul>

Пример запроса и ответа:
~~~
POST /api/articles HTTP/1.1
Host: localhost:8080
Content-Type: multipart/formdata
Authorization: Bearer <jwt_token>

{
    "title": "Заголовок статьи",
    "content": "Текст статьи",
    "status": "Опубликовано",
    "tags": ["тег1", "тег2"],
    "photo": <изображение для статьи>
}
~~~

~~~
{
    "_id": "645a528c0d13a19d6f0bf7e2",
    "title": "Заголовок статьи",
    "text": "Текст статьи",
    "status": "Опубликовано",
    "tags": ["тег1", "тег2"],
    "photo": "1683640972_645a528c27e28.jpg",
    "created_at": 1683650708000,
    "created_by": "645a769f594575aa79f9a832"
    "date": 1683652232000
}

~~~

</br>
Возможные ошибки:
<ul>
  <li>401 Unauthorized - пользователь не авторизован</li>
  <li>422 Unprocessable Entity - некорректные параметры запроса или тела запроса</li>
  <li>500 Internal Server Error - ошибка сервера при обновлении статьи</li>
</ul>
</br>

---

<strong>Эндпоинт: </strong>/article/update/{id}</br>
<strong>Метод: </strong>POST</br>
<strong>Описание:</strong> Вносит изменения в существующую статью</br>

<strong>Параметры запроса:</strong>
<ul>
  <li>title - заголовок статьи</li>
  <li>photo - фото</li>
  <li>text - основной текст статьи</li>
  <li>status - Статус статьи (Опубликовано/Не опубликовано)</li>
  <li>tags - теги статьи</li>
</ul>

Пример запроса и ответа:
~~~
POST /api/articles/update?id=645a528c0d13a19d6f0bf7e2 HTTP/1.1
Host: localhost:8080
Content-Type: multipart/formdata
Authorization: Bearer <jwt_token>

{
    "title": "Заголовок статьи",
    "text": "Текст статьи",
    "status": "Опубликовано",
    "tags": ["тег1", "тег2"],
    "photo": <изображение для статьи>
}
~~~

~~~
{
    "_id": "645a528c0d13a19d6f0bf7e2",
    "title": "Заголовок статьи",
    "text": "Текст статьи",
    "status": "Опубликовано",
    "tags": ["тег1", "тег2"],
    "photo": "1683640972_645a528c27e28.jpg",
    "created_at": 1683650708000,
    "created_by": "645a769f594575aa79f9a832"
    "updated_at": 1683652232000
    "updated_by": "645a769f594575aa79f9a832"
}
~~~
</br>
Возможные ошибки:
<ul>
  <li>404 Not Found - запрашиваемая статья не найдена</li>
  <li>401 Unauthorized - пользователь не авторизован</li>
  <li>422 Unprocessable Entity - некорректные параметры запроса или тела запроса</li>
  <li>500 Internal Server Error - ошибка сервера при обновлении статьи</li>
</ul>

---

</br>
<strong>Эндпоинт: </strong>/article/delete/{id}</br>
<strong>Метод: </strong>DELETE</br>
<strong>Описание:</strong> Удаляет статью</br>
<strong>Параметры запроса:</strong>
<ul>
  <li>id - обязательный идентификатор удаляемой модели</li>
</ul>

Пример запроса и ответа:
~~~
DELETE http://localhost:8080/api/article/1
Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiIxMjM0NTY3ODkwIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c
~~~

~~~
{
   HTTP/1.1 204 No Content
}
~~~
</br>
Возможные ошибки:
<ul>
  <li>400 Not Found - запрос был неверно сформирован</li>
  <li>404 Not Found - запрашиваемый ресурс не найден</li>
  <li>401 Unauthorized - пользователь не авторизован</li>
  <li>500 Internal Server Error - ошибка сервера при обновлении статьи</li>
</ul>

---

<strong>Эндпоинт: </strong>/article/add-view/{id}</br>
<strong>Метод: </strong>POST</br>
<strong>Описание:</strong> Удаляет статью</br>

<strong>Параметры запроса:</strong>
<ul>
  <li>id - обязательный идентификатор удаляемой модели</li>
</ul>

Пример запроса и ответа:
~~~
POST http://localhost:8080/api/article/add-view?id=1
~~~

~~~
{
    "status": "Опубликовано",
    "views": [
        "1683653435000"
    ],
    "_id": "645a78944493a969fd0a33a8",
    "title": "FFFFFF",
    "created_by": "645a769f594575aa79f9a832",
    "created_at": "1683650708000",
    "date": "1683652232000",
    "updated_at": "1683653435000",
    "updated_by": "645a769f594575aa79f9a832"
}
~~~
</br>
Возможные ошибки:
<ul>
  <li>500 Internal Server Error - ошибка сервера при обновлении статьи</li>
</ul>

<h2> Документация для работы с коллекцией 'settings'</h2>

<strong>Эндпоинт: </strong>/settings/view/{name}</br>
<strong>Метод: </strong>GET</br>
<strong>Описание:</strong> Получает значение модели по задангому имени</br>
<strong>Параметры запроса:</strong>
<ul>
  <li>name - обязательный параметр имени параметра настройки</li>
</ul>

Пример запроса и ответа:
~~~
GET http://localhost:8080/api/settings/view?name=admin_page_count
~~~

~~~
{
   "name": "admin_page_count" ,
   "value": 10
}
~~~
</br>
Возможные ошибки:
<ul>
  <li>422 Unprocessable Entity - некорректные параметры запроса или тела запроса</li>
  <li>500 Internal Server Error - ошибка сервера при обновлении статьи</li>
</ul>

---

<strong>Эндпоинт: </strong>/settings/update/{name}</br>
<strong>Метод: </strong>POST</br>
<strong>Описание:</strong> Обновляет значение модели c заданным именем</br>
<strong>Параметры запроса:</strong>
<ul>
  <li>name - обязательный параметр имени параметра настройки</li>
</ul>

Пример запроса и ответа:
~~~
POST http://localhost:8080/api/settings/update?name=admin_page_count
Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiIxMjM0NTY3ODkwIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c
~~~

~~~
{
   "name": "admin_page_count" ,
   "value": 11
}
~~~
</br>
Возможные ошибки:
<ul>
  <li>422 Unprocessable Entity - некорректные параметры запроса или тела запроса</li>
  <li>500 Internal Server Error - ошибка сервера при обновлении статьи</li>
</ul>

<h2> Документация для работы с коллекцией 'user'</h2>

Данный API позволяет пользователю авторизироваться и обновлять JSON Web Token (JWT), используя токен обновления, отправленный в HttpOnly cookie. Также он позволяет получить информацию о пользователе по идентификатору пользователя (ID).

---

### Заголовки
Заголовки, необходимые для всех запросов к API:

~~~
Accept: application/json
Content-Type: application/json
~~~

---

<strong>Эндпоинт: </strong>/user/login</br>
<strong>Метод: </strong>POST</br>
<strong>Описание:</strong> Выдает временный ключ доступа</br>
<strong>Параметры запроса:</strong>
<ul>
  <li>name - обязательный параметр имени параметра настройки</li>
</ul>

Пример запроса и ответа:

~~~
POST http://localhost:8080/api/user/login

{
    "username": "myusername",
    "password": "mypassword"
}
~~~

~~~
{
    "token": "JWT-токен"
}

//или c ошибкой, к примеру:
{
    "errors": {
        "username": ["Username cannot be blank."],
        "password": ["Password cannot be blank."]
    }
}
~~~
</br>
Возможные ошибки:
<ul>
  <li>500 Internal Server Error - ошибка сервера при обновлении статьи</li>
</ul>

---

<strong>Эндпоинт: </strong>/user/refresh-token</br>
<strong>Метод: </strong>POST</br>
<strong>Описание: </strong>Обновляет JWT с помощью токена обновления, отправленного в HttpOnly cookie. Эндпоинт доступен только для запросов методом POST</br>

Пример запроса и ответа:

~~~
POST http://localhost:8080/api/user/refresh-token
~~~

~~~
{
    "token": "Новый JWT-токен"
}
~~~
</br>
Возможные ошибки:
<ul>
  <li>401 Unprocessable Entity - некорректные параметры запроса или тела запроса</li>
  <li>500 Internal Server Error - ошибка сервера при обновлении статьи</li>
</ul>

---

<strong>Эндпоинт: </strong>/user/view/{id}</br>
<strong>Метод: </strong>GET</br>
<strong>Описание: </strong>Получает информацию о пользователе по идентификатору (ID). Эндпоинт доступен только для запросов методом GET</br>

Пример запроса и ответа:

~~~
POST http://localhost:8080/api/user/view?id=645a769f594575aa79f9a832
~~~

~~~
{
    "username": "myusername"
}
~~~
</br>
Возможные ошибки:
<ul>
  <li>500 Internal Server Error - ошибка сервера при обновлении статьи</li>
</ul>

## Примечания

<i>*Пагинатор появляется когда число страниц больше одной</li><br>
<i>*При работе в административной панели не забывайте нажимать "Сохранить", в противном случае изменения не будут внесены</i><br>