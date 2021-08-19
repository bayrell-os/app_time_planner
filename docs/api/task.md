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
GET /api/user.tasks/crud/search/?filter[]=["status","=",1]
```

Текущие задачи на неделю:
```
GET /api/user.tasks/crud/search/?filter[]=["gmdate_plan_begin",">=","2021-08-16 00:00:00"]&filter[]=["gmdate_plan_begin","<=","2021-08-16 23:59:59"]
```
Задачи с 2021-08-22 00:00:00 по 2021-08-16 23:59:59 включительно в часовом поясе UTC.

**Ответ**
```
{
  "data": {
    "items": [
      {
        "id": 7,
        "target_id": 10,
        "user_id": null,
        "status": 1,
        "name": "Task 7",
        "description": "",
        "gmdate_plan_begin": "2021-08-16 12:00:00",
        "gmdate_plan_end": "2021-08-16 12:00:00",
        "gmdate_work_begin": null,
        "gmdate_work_end": null,
        "work_hours": 0,
        "pos": 0
      },
      {
        "id": 8,
        "target_id": 10,
        "user_id": null,
        "status": 1,
        "name": "Task 8",
        "description": "",
        "gmdate_plan_begin": "2021-08-16 12:00:00",
        "gmdate_plan_end": "2021-08-16 12:00:00",
        "gmdate_work_begin": null,
        "gmdate_work_end": null,
        "work_hours": 0,
        "pos": 0
      },
      {
        "id": 11,
        "target_id": 10,
        "user_id": null,
        "status": 1,
        "name": "Task 11",
        "description": "",
        "gmdate_plan_begin": "2021-08-16 12:00:00",
        "gmdate_plan_end": "2021-08-16 12:00:00",
        "gmdate_work_begin": null,
        "gmdate_work_end": null,
        "work_hours": 0,
        "pos": 0
      }
    ],
    "filter": [
      [
        "status",
        "=",
        1
      ]
    ],
    "start": 0,
    "limit": 1000,
    "total": 3
  },
  "error": {
    "code": 1,
    "str": "",
    "name": ""
  }
}
```


## Поиск задачи по ID

**Запрос**

Этот запрос возвращает задачу текущего пользователя по ее ID.

```
GET /api/user.tasks/crud/item/2/
```

**Ответ**
```
{
  "data":
  {
    "item":
    {
      "id": 2,
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
    },
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
POST {{api_url}}/user.tasks/crud/create/ HTTP/1.1
Content-Type: application/json

{
  "data":
  {
    "item":
    {
      "name": "New task",
      "target_id": 10,
      "gmdate_plan_begin": "2021-08-16 12:00:00",
      "status": "0"
    }
  }
}
```

**Ответ**
```
{
  "data": {
    "item": {
      "id": 16,
      "target_id": 10,
      "user_id": null,
      "status": 0,
      "name": "New task",
      "description": "",
      "gmdate_plan_begin": "2021-08-16 12:00:00",
      "gmdate_plan_end": "2021-08-16 12:00:00",
      "gmdate_work_begin": null,
      "gmdate_work_end": null,
      "work_hours": 0,
      "pos": 0
    }
  },
  "error": {
    "code": 1,
    "str": "",
    "name": ""
  }
}
```


## Редактирование задачи

**Запрос**
```
POST /api/user.tasks/crud/edit/9/ HTTP/1.1
Content-Type: application/json

{
  "data":
  {
    "item":
    {
      "name": "New task 2",
      "description": "Description",
      "status": 1
    }
  }
}
```

**Ответ**
```
{
  "data": {
    "item": {
      "id": 9,
      "target_id": 10,
      "user_id": null,
      "status": 1,
      "name": "New task 2",
      "description": "Description",
      "gmdate_plan_begin": "2021-08-16 12:00:00",
      "gmdate_plan_end": "2021-08-16 12:00:00",
      "gmdate_work_begin": null,
      "gmdate_work_end": null,
      "work_hours": 0,
      "pos": 0
    }
  },
  "error": {
    "code": 1,
    "str": "",
    "name": ""
  }
}
```


## Удаление задачи

**Запрос**
```
DELETE {{api_url}}/user.tasks/crud/delete/9/ HTTP/1.1
```

**Ответ**
```
{
  "data": {
    "id": 10,
    "target_id": 10,
    "user_id": null,
    "status": 0,
    "name": "Task 10",
    "description": "",
    "gmdate_plan_begin": "2021-08-16 12:00:00",
    "gmdate_plan_end": "2021-08-16 12:00:00",
    "gmdate_work_begin": null,
    "gmdate_work_end": null,
    "work_hours": 0,
    "pos": 0
  },
  "error": {
    "code": 1,
    "str": "",
    "name": ""
  }
}
```
