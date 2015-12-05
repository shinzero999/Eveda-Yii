<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'eveda',
    'name' => 'Eveda',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
        ],
    ],
    'components' => [
        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [

                '<action:repairs-returns|faq|find-dealer|login|signup|logout|drysuit-designer|terms|360-tour|print-order>' => 'site/<action>',

                '<module:admin>/<controller:\w+>/<id:\d+>' => '<module>/<controller>/view',
                '<module:admin>/<controller:\w+>/<action:\w+[\w-]*>/<id:\d+>' => '<module>/<controller>/<action>',
                '<module:admin>/<controller:\w+>/<action:\w+[\w-]*>' => '<module>/<controller>/<action>',
                '<module:admin>/<controller:\w+>' => '<module>/<controller>/index',

                'admin/?' => 'admin/default/index',
                
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+[\w-]*>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+[\w-]*>' => '<controller>/<action>',
                '<controller:\w+>' => '<controller>/index',

                '<action:\w+>' => 'site/<action>',

                '' => 'site/index',
            ],
            'ignoreLanguageUrlPatterns' => [
                '@^admin/.*@' => '@^admin/.*@',
                '@^admin/?@' => '@^admin/?@',
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'eveda',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser', // required for POST input via `php://input`
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
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
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => '',
                'username' => '',
                'password' => '',
                'port' => '',
                'encryption' => '',
            ],
            'useFileTransport' => false,
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
        'i18n'=>[
            'translations' => [
                'order'=>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => "@app/messages",
                    'sourceLanguage' => 'en_US',
                    'fileMap' => [
                        'order' => 'order.php',
                    ]
                ],
            ]
        ],
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
