## Документация для API

## __Описание__
Это документация для API нашего приложения. Все эндпоинты начинаются с http://localhost:8080/api/.

## Документация для работы с коллекцией 'article'

__Эндпоинт:__ /articles

__Метод:__ GET

__Описание:__ Получить список статей в коллекции

__Параметры запроса:__

  * status - статус статей для фильтрации (опционально)
  * tags - теги статей для фильтрации (опционально)
  * limit - максимальное количество статей в ответе (опционально)
  * sort - параметр сортировки (опционально, по умолчанию created_at)
  * page - номер страницы (опционально, по умолчанию 1)
  * pop - фильтр на просмотры (опционально)

__Примеры запросов и ответов:__

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

  * 422 Unprocessable Entity - некорректные параметры запроса или тела запроса
  * 500 Internal Server Error - ошибка сервера

---

__Эндпоинт:__ /get-count

__Метод:__ GET

__Описание:__  Возвращает количество статей в коллекции MongoDB, которые соответствуют заданным фильтрам


__Параметры запроса:__

  * status - статус статей для фильтрации (опционально)
  * tags - теги статей для фильтрации (опционально)
  * pop - фильтр на просмотры (опционально)


Пример запроса и ответа:
~~~
GET http://localhost:8080/api/get-count?status=Опубликовано&tags=tech&pop=true
~~~

~~~
0
~~~
Возможные ошибки:

  * 422 Unprocessable Entity - некорректные параметры запроса или тела запроса
  * 500 Internal Server Error - ошибка сервера

---

__Эндпоинт:__ /article

__Метод:__ POST

__Описание:__ Создает новую статью

__Параметры запроса:__

  * title - заголовок статьи (обязательный)
  * photo - фото
  * text - основной текст статьи
  * status - Статус статьи (опубликовано/Не опубликовано)
  * tags - теги статьи


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

__Возможные ошибки:__

  * 401 Unauthorized - пользователь не авторизован
  * 422 Unprocessable Entity - некорректные параметры запроса или тела запроса
  * 500 Internal Server Error - ошибка сервера

---

__Эндпоинт:__ /article/update?id

__Метод:__ POST

__Описание:__ Вносит изменения в существующую статью

__Параметры запроса:__

  * id - идентификатор модели
  * title - заголовок статьи
  * photo - фото
  * text - основной текст статьи
  * status - Статус статьи (Опубликовано/Не опубликовано)
  * tags - теги статьи


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

__Возможные ошибки:__

  * 404 Not Found - запрашиваемая статья не найдена
  * 401 Unauthorized - пользователь не авторизован
  * 422 Unprocessable Entity - некорректные параметры запроса или тела запроса
  * 500 Internal Server Error - ошибка сервера

---

__Эндпоинт:__ /article/delete?id

__Метод:__ DELETE

__Описание:__ Удаляет статью

__Параметры запроса:__

* id - идентификатор удаляемой модели

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

Возможные ошибки:

  * 400 Not Found - запрос был неверно сформирован
  * 404 Not Found - запрашиваемый ресурс не найден
  * 401 Unauthorized - пользователь не авторизован
  * 500 Internal Server Error - ошибка сервера

---

__Эндпоинт:__ /article/add-view?id

__Метод:__ POST

__Описание:__ Удаляет статью

__Параметры запроса:__

  * id -  идентификатор удаляемой модели


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

Возможные ошибки:

  * 500 Internal Server Error - ошибка сервера

## Документация для работы с коллекцией 'settings'

__Эндпоинт:__/settings/view?name

__Метод:__ GET

__Описание:__ Получает значение модели по задангому имени

__Параметры запроса:__

  * name - имя параметра настройки

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

Возможные ошибки:

  * 422 Unprocessable Entity - некорректные параметры запроса или тела запроса
  * 500 Internal Server Error - ошибка сервера 


---

__Эндпоинт:__ /settings/update?name

__Метод:__ POST

__Описание:__ Обновляет значение модели c заданным именем

__Параметры запроса:__

  * name - имя параметра настройки

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

Возможные ошибки:

  * 422 Unprocessable Entity - некорректные параметры запроса или тела запроса
  * 500 Internal Server Error - ошибка сервера

## Документация для работы с коллекцией 'user'

Данный API позволяет пользователю авторизироваться и обновлять JSON Web Token (JWT), используя токен обновления, отправленный в HttpOnly cookie. Также он позволяет получить информацию о пользователе по идентификатору пользователя (ID).

---

### Заголовки
Заголовки, необходимые для всех запросов к API:

~~~
Accept: application/json
Content-Type: application/json
~~~

---

__Эндпоинт:__ /user/login

__Метод:__ POST

__Описание:__ Выдает временный ключ доступа

__Параметры запроса:__

  * username" - имя пользователя
  * password" - пароль
  
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

Возможные ошибки:

  * 422 Unprocessable Entity - некорректные параметры запроса или тела запроса
  * 500 Internal Server Error - ошибка сервера


---

__Эндпоинт:__ /user/refresh-token

__Метод:__ POST

__Описание:__ Обновляет JWT с помощью токена обновления, отправленного в HttpOnly cookie. Эндпоинт доступен только для запросов методом POST

Пример запроса и ответа:

~~~
POST http://localhost:8080/api/user/refresh-token
~~~

~~~
{
    "token": "Новый JWT-токен"
}
~~~

Возможные ошибки:

  * 401 Unauthorized - пользователь не авторизован
  * 500 Internal Server Error - ошибка сервера

---

__Эндпоинт:__ /user/view?id

__Метод:__ GET

__Описание:__ Получает информацию о пользователе по идентификатору (ID). Эндпоинт доступен только для запросов методом GET

Пример запроса и ответа:

~~~
POST http://localhost:8080/api/user/view?id=645a769f594575aa79f9a832
~~~

~~~
{
    "username": "myusername"
}
~~~

Возможные ошибки:

  * 500 Internal Server Error - ошибка сервера 
