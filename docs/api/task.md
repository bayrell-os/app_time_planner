# API Task

## Поиск задач

**Запрос**
```
/api/task/
{
  "filter":
  [
    {
      "field": "is_deleted",
      "op": "=",
      "value": 0,
    },
	{
      "field": "status",
      "op": "=",
      "value": "NEW",
    },
  ],
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


## Создание задачи

**Запрос**
```
/api/task/create
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
/api/task/21/edit
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
/api/task/21/delete
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
