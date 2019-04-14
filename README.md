Yii2: Проект "Urban News"
============================


**Автор** - Даныбаев Санжар



Данный тестовый проект выполнен с учетом всех требований **Middle Developer**, указанных в тестовом задании.

**Затраченное время**  - 1.5 недели


Разработка проекта разделилась на 4 этапа:

1. Планирование
2. Дизайн
3. Разработка
4. Тестирование

_Помимо реализации функционала я занимался разработкой оригинального интерфейса с упором на UX._

**P.S.** Всю документацию, изучение и работу в программировании я веду на английском языке. Поэтому в Трелло, так же как и в самом проекте используется английский в качестве основного языка.


Система уведомлений
------------
Для отправки уведомлений используетcя сервис [Pusher](http://pusher.com) вместо архитектуры `Redis` и `NodeJS`.

Для данного проекта я создал 2 класса `ModelNotification` и `AdminNotifications` которые занимаются  процессом отправки любых уведомлений.

1. `ModelNotification` - данный клас используется в тех случаях, когда наступают события в моделях.

2. `AdminNotifications` - данный клас используется в тех случаях, когда администратор отправляет сообщение конкретному пользователю, группе пользователей или всем сразу.

#### Добавление новых типов уведомлений
- Для добавления `Telegram уведомлений`, необходимо реализовать функцию `sendTelegramNotification` в `AdminNotifications` классе и описать логику действий  для `case('telegram')` в операторе `switch` в классе `Model Notification` 

- Добавление любых других типов уведомлений происходит аналогичным образом 


Требования
------------
В связи с наличием определенных зависимостей, Ваш Web сервер должен поддерживать `PHP-7`.

Должны быть установлены и включены  следующие `php` модули:

1. `php7.0-mbstring`

2.  ` php7.0-curl`

3. `php7.0-dom`

4. `php7.0-intl`


Для их установки введите следующую комманду в терминале
 
` apt-get install php7.0-mbstring php7.0-curl php7.0-dom
 php7.0-intl
`

Установка
------------
* Создайте копию проекта

    ```
    git clone https://github.com/Sanzhar-Danybayev-Excelsior/urban.news
    cd urban.news
    ```

* Установите Composer, если он не установлен

    ```
    php -r "copy('https://getcomposer.org/installer','composer-setup.php');"
    ```

    ```
     php composer-setup.php
    ```

* Установите зависимости

    ```
    php composer.phar install
    ```

* Отредактируйте  файл `config/db.php`, вставив данные, указанные ниже.  Для данного проекта уже создана пустая база данных.

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=5.101.120.35;dbname=admin_portal',
    'username' => 'admin_root',
    'password' => '2iZKI0Ru3I',
    'charset' => 'utf8',
];
```
 
* Запустите все миграции

```
php yii migrate --migrationPath=@yii/rbac/migrations

php yii migrate
```

* Выполните следующие команды для добавления разрешений, ролей и правил

```
php yii assign/addpermissions

php yii assign/addroles

php yii assign/rule
```

* Заполните базу данных первоночальными данными.
        
```
php yii seeder/seed
```

* Сделайте папку web доступной
        
```
sudo chmod -R 777 web/
```

#### Замечания:

* Использование миграций, добавление разрешений, ролей и правил критичны для работы проекта.

* Для использования email и push уведомлений должно быть интернет соединение

Тестирование
------------
Чтобы запустить unit и functional тесты нужно обновить конфигурационный файл  `tests/codeception.yml`, обновив значения `test_entry_url`, `url`, `dsn`,`user`, `password` на те, что используются в запущенном проекте.

Если Вы используете предоставленную базу данных `admin_portal`, то значения `dsn`, `user`, `password` не меняются.

```
config:
    test_entry_url: http://news.portal/index.php
modules:
    enabled:
        - PhpBrowser:
                   url: 'http://news.portal'
                   curl:
                       CURLOPT_RETURNTRANSFER: true
        - Db:
            dsn: 'mysql:host=5.101.120.35;dbname=admin_portal;charset=utf8'
            user: 'admin_root'
            password: '2iZKI0Ru3I'
```
Если Вы используете Linux, то замените '\\' на '/' в значении `configFile`, находящимся в   `tests/codeception/functional.suite.yml`
##### Результат изменений
```
class_name: FunctionalTester
modules:
    enabled:
      - Filesystem
      - Yii2
    config:
      Yii2:
          configFile: 'codeception/config/functional.php'
```

### Запуск тестов
Чтобы запустить оба теста, выполните следующие команды

```
cd tests
..\vendor\bin\codecept.bat run
```
#### Изображение результата

![alt text](https://trello-attachments.s3.amazonaws.com/58be8d6ad27de7c07cfdf339/656x587/eeaf30b00e9676658e4b1b81a778d8db/%D0%B7%D0%B0%D0%B3%D1%80%D1%83%D0%B6%D0%B5%D0%BD%D0%BE_7.3.2017_%D0%B2_16_37_31.png "Результаты тестирования")

Дополнительные данные
------------
Для простоты тестирования, в проекте уже зарегистрированы следующие пользователи:

1. Администратор

    `Логин - admin`
    
    `Пароль - qwe123`
    
    `email - tester.dev.env@mail.ru`
  
      `Пароль от почты - qwe123#@!`
      
2. Модератор
  
    `Логин - moderator`
  
     `Пароль - qwe123`
  
     `email - moderator.dev.env@mail.ru`
     
     `Пароль от почты - qwe123#@!`



3.  Читатель
     
    `Логин - reader`
    
    `Пароль - qwe123`
    
    `email - registered.user.dev@mail.ru`
    
    `Пароль от почты - qwe123#@!`
