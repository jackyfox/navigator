<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
	'language' => 'ru-RU',
    'sourceLanguage' => 'ru-RU',
    'timeZone' => 'Europe/Moscow',
    'id' => 'app-frontend',
    'name'=>'ГИС «НАВИГАТОР ПРОФЕССИЙ САНКТ-ПЕТЕРБУРГА»',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    //'defaultRoute'=>'site/index',//маршрут по умолчанию
    //'defaultRoute'=>'post/index',//маршрут по умолчанию
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',//убирает web из адреса
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        //правила для маршрутизации
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            //'enableStrictParsing' => false,
            'rules' => [
                [
                    'pattern'=>'/',
                    'route' => 'site/index',
                    //'route' => 'post/index',
                    'suffix' => '',
                ],
                [
                    'pattern'=>'about',
                    'route' => 'site/about',
                    'suffix' => '.html',
                ],
                
                '<action:\w+>' => 'site/<action>',
                '<action:>' => 'post/<action>',
            ],
        ],
        //конец правила для маршрутизации
    ],
    'params' => $params,

];
