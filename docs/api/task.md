# API Task

## Поиск задач

**Запрос**

Этот запрос возвращает задачи текущего пользователя. По умолчанию выводиться максимум 1000 записей

```
GET /api/user.tasks/crud/search/
```

Получить 10 текущих задач пользователя, начиная с 5.
```
GET /api/user.tasks/crud/search/?start=5&limit=10
```

Новые задачи:
```
GET /api/user.tasks/crud/search/?filter[]=["status","=",0]
```

Текущие задачи на неделю:
```
GET /api/user.tasks/crud/search/?filter[]=["gmdate_plan_begin",">=","2021-08-16 00:00:00"]&filter[]=["gmdate_plan_begin","<=","2021-08-16 23:59:59"]
```
Задачи с 2021-08-22 00:00:00 по 2021-08-16 23:59:59 включительно в часовом поясе UTC.

**Ответ**
```
{
  "data":
  {
    "items":
    [
      "id": 21,
      "name": "Название задачи",
      "description": "Описание задачи",
      "target_id": 10,
      "user_id": 1,
      "gmdate_plan_begin": "2021-08-16 12:00:00",
      "gmdate_plan_end": "2021-08-16 14:00:00",
      "gmdate_work_begin": null,
      "gmdate_work_end": null,
      "work_hours": 0,
      "status": 0,
      "pos": 0,
    ],
    "start": 0,
    "total": 1,
  },
  "error":
  {
    "code": 1,
    "str": "",
    "name": "",
  }
}
```


## Создание задачи

**Запрос**
```
/api/user/task/create
{
  "data":
  {
    "name": "Новая задача",
    "target_id": 10,
    "date": 1626965799,
	"status": "NEW",
	"user_id": null,
  },
}
```

**Ответ**
```
{
  "data":
  {
    "id": 21,
    "name": "Новая задача",
    "target_id": 10,
    "date": 1626965799,
	"status": "NEW",
	"user_id": null,
  },
  "error":
  {
    "message": "",
    "class_name": "",
  }
}
```


## Редактирование задачи

**Запрос**
```
/api/user/task/21/edit
{
"data":
  {
    "name": "Новое название задачи"
  },
}
```

**Ответ**
```
{
  "data":
  {
    "id": 21,
    "name": "Новое название задачи",
    "target_id": 10,
    "date": 1626965799,
    "status": "NEW",
    "user_id": null,
  },
  "error":
  {
    "message": "",
    "class_name": "",
  }
}
```


## Удаление задачи

**Запрос**
```
/api/user/task/21/delete
```

**Ответ**
```
{
  "data":
  {
    "id": 21,
    "name": "Новое название задачи",
    "target_id": 10,
    "date": 1626965799,
    "status": "NEW",
    "user_id": null,
  },
  "error":
  {
    "message": "",
    "class_name": "",
  }
}
```
