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

Также вам необходимо создать таблицы для хранения данных с помощью команды `./yii migrate 6 && ./yii migrate --migrationPath=@yii/rbac/migrations && ./yii rbac/init`

### 3. Шифрования cookies

По умолчанию включено шифрование кук с помощью специального ключа. В файле `config/web.php` замените значение `cookieValidationKey` на любое своё. Например:

```php
'request' => [
    'cookieValidationKey' => 'qwerty',
]
```

### 4. Улучшение производительности

* Скачайте и распакуйте https://developers.google.com/closure/compiler/ и https://github.com/yui/yuicompressor/ в корень проекта под названиями compiler.jar и yuicompressor.jar, соответственно.

* Необходимо скомпилировать css и js файлы с помощью команды `./yii asset assets.php config/assets-prod.php`

* В файле `config/web.php` раскомментируйте

```php
'assetManager' => [
    'bundles' => require(__DIR__ . '/assets-prod.php')
]
```
