Расширение для yii2 mentor
==========================
Расширение для yii2 mentor

1.Установка
------------

Устанавливаем через [composer](http://getcomposer.org/download/).


```
composer require --prefer-dist qviox/yii2-mentor "*"
```

или добавляем

```
"qviox/yii2-mentor": "*"
```

в секцию require `composer.json` файла.

2.Выполняем миграции
-----
```
yii migrate --migrationPath=@qviox/mentor/migrations --interactive=0
```
3.Настраиваем конфигурацию
-----

В файле `config/web.php` (yii2 Basic) подключаем расширение
```php
'modules' => [
                'mentor'=>[
                            'class'=>'qviox\mentor\Module',
                            'userTable'=>'user',
                            'uploads'=>'uploads/mentor',
                            'adminEmails'=>['example@gmail.com','example2@gmail.com'],
                            
                        ],
                        ...
]
```

#### Параметры
>**userTable** - имя таблицы с пользователями, должна содержать столбцы "id","email" `(Обязательный параметр)`

>**uploads** - путь к директории для сохранения файлов `(Обязательный параметр)`

>**adminEmails** - Массив с Emails. Назначает пользователям роль SUPERADMIN  `(Обязательный параметр)`

>**userAttributes** - Замена имен столбцов `name(имя пользователя)`, `surname(фамилия пользователя)`  таблицы userTable. `(Необязательный параметр)`

По умолчанию : 
```php
 [ 'name'=>'name','surname'=>'surname'];
 ```
к примеру если у вас вместо столбцов `name,surname` один столбец `fio`, то указываем:
```php
 [ 'name'=>'fio','surname'=>null];
 ```
>**layout** - путь к шаблону админки

 
4.Методы
-----
>4.1.  Получение списка ссылок для админки
```php
 @qviox/mentor/Menu::getAdminMenu()
 
Формат возвращаемых данных:
 ['label' => 'Меню конкурса', 'icon' => 'calendar ',
        'items' => [
            ['label' => 'label, 'icon' => 'user', 'url' => url], 
            ...
        ]],
 ```
 
5.Список методов api
-----

>5.1.  Получение рейтинга участников 
`/mentor/api/ajax/get-users-rate` 

>5.2  Получение общего бала
`/mentor/api/ajax/get-total-points-by-session` 

>5.3  Получение навыков пользователя
`/mentor/api/ajax/get-user-skills` 

>5.4  Получение командного рейтинга
`/mentor/api/ajax/get-teams-rate` 

>5.5  Проверка выполнил ли пользователь уже задание
`/mentor/api/ajax/check-task-questionnaire?taskId=id` 

>5.6  Сохранение анкеты пользователя (POST)
`/mentor/api/ajax/set-competition-questionnaire` 

>5.7  Сохранение формы задания (POST)
`/mentor/api/ajax/save-task-data` 

>Образцы полей формы
> `id - id поля`

`<input type="text" class="form-control" name="TaskInput[id]">`

`<textarea class="form-control" name="TaskInput[id]"></textarea>`

`<input type="file" class="form-control" name="TaskInputFile[TaskInputFiles][id][]">`

`<input type="file" class="form-control" name="TaskInputFile[TaskInputFiles][id][]" multiple="">`