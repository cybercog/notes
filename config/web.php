<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'name' => 'Онлайн-заметки',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
//        'assetManager' => [
//            'bundles' => require(__DIR__ . '/assets-prod.php')
//        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
            'cache' => 'cache'
        ],
        'cache' => [
            'class' => 'yii\caching\DbCache',
            'db' => 'db',
            'cacheTable' => 'cache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                '' => 'site/index',
                'captcha' => 'site/captcha',
                'contact' => 'site/contact',
                'about' => 'site/about',
                'edit-profile' => 'site/profile',
                'signup' => 'site/signup',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'home' => 'site/home',
                'notes' => 'note/index',
                'note/<id:\d+>' => 'note/view',
                'note/create' => 'note/create',
                'note/<id:\d+>/edit' => 'note/update',
                'note/<id:\d+>/delete' => 'note/delete',
                'admin/statistic' => 'admin/statistic',
                'admin/users' => 'admin/users',
                'admin/notes' => 'admin/notes',
                'users/<id:\d+>/edit' => 'user/update',
                'users/<id:\d+>/delete' => 'user/delete',
                'comment/<id:\d+>/edit' => 'comment/update',
                'comment/<id:\d+>/delete' => 'comment/delete'
            ]
        ],
        'request' => [
            'cookieValidationKey' => 'kzVHkoS1trHHoMwNGJMuUtmRPzfNpJHH',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
