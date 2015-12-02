<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'language' => 'zh-CN', //增加此行，默认使用中文
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'defaultRoute' => 'index',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['public/nologin'],
        ],
        'urlManager' => [
            'enablePrettyUrl' => TRUE,
            'showScriptName' => FALSE,
            'enableStrictParsing' => FALSE,
            'suffix' => '.html',
            'rules' => [
                'product/buy/<id:\d+>' => 'product/buy',
                'member/product/look/<id:\d+>' => 'member/product/look',
                'public/<action:\w+>/<id:\d+>/<stoken:\w+>' => 'public/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'maxFileSize' => 1024,
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'index/error',
        ],
    ],
    'modules' => [
        'member' => [
            'class' => 'app\modules\member\MemberModule',
            'defaultRoute' => 'index',
        ],
    ],
    'params' => $params,
];
