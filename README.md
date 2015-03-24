СЕРВИС ЗАМЕТОК
================================

ТРЕБОВАНИЯ
------------

PHP >= 5.4.0.


НАСТРОЙКИ
-------------

### 1. Зависимости

Необходимо установить зависимости с помощью команды `composer install`.

### 2. База данных

Измените данные соединения с базой данных в файле `config/db.php` на ваши данные, например:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'vasya',
    'password' => 'qwerty',
    'charset' => 'utf8',
];
```

Также вам необходимо создать таблицы с помощью команды `./yii migrate && ./yii migrate --migrationPath=@yii/rbac/migrations && ./yii rbac/init`
