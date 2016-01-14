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
        'image' => [
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD', //GD or Imagick
        ],
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
                'product/showmymoney/<id:\d+>' => 'product/showmymoney',
                'product/addproduct/<id:\d+>' => 'product/addproduct',
                'product/buy/<id:\d+>' => 'product/buy',
                'logistics/publishlogistics/<id:\d+>' => 'logistics/publishlogistics',
                'logistics/detail/<id:\d+>' => 'logistics/detail',
                'logistics/book/<id:\d+>' => 'logistics/book',
                'logistics/books/<id:\d+>' => 'logistics/books',
                'logistics/vouch/<id:\d+>' => 'logistics/vouch',
                'member/logistics/selectimg/<id:\d+>' => 'member/logistics/selectimg',
                'member/logistics/changeimg/<id:\d+>' => 'member/logistics/changeimg',
                'member/logistics/fitlogis/<id:\d+>/<type:\d+>/' => 'member/logistics/logistics',
                'member/product/cancelsellproduct/<id:\d+>' => 'member/product/cancelsellproduct',
                'member/product/suresellproduct/<id:\d+>' => 'member/product/suresellproduct',
                'member/account/getgift/<id:\d+>/<type:\d+>/' => 'member/account/getgift',
                'member/product/selectimg/<id:\d+>' => 'member/product/selectimg',
                'member/product/rate/<id:\d+>' => 'member/product/rate',
                'member/product/changeimg/<id:\d+>' => 'member/product/changeimg',
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
        'wechat' => [
            'class' => 'app\modules\wechat\wechatModule',
            'defaultRoute' => 'api',
        ],
    ],
    'params' => $params,
];
