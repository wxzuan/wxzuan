<?php

return [
    'name' => '赚赚乐',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'smser' => [
            // 微信支付
            'class' => 'extensions\wxzuanpay\Wxzuanpay',
        ]
    ],
];
