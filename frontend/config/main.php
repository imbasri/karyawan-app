<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
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
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                '/' => 'site/index',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'signup' => 'site/signup',
                'request-password-reset' => 'site/request-password-reset',
                'reset-password' => 'site/reset-password',
                'verify-email' => 'site/verify-email',
                'resend-verification-email' => 'site/resend-verification-email',
                'biodata/<id:\d+>' => 'site/pelamar',
                'biodata/delete/<id:\d+>' => 'site/delete-biodata',
                'biodata' => 'site/mydata', // Jika `id` tidak disediakan
                'list' => 'site/list-biodata',
            ],
            'enableStrictParsing' => false, // Disable strict parsing for broader matching options
        ],
    ],
    'params' => $params,
    'defaultRoute' => 'site/index',
];
