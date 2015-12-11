<?php

return[
    'components' => [
        'wechat' => [
            'class' => 'app\modules\wechat\components\WechatCheck',
            'APPID' => "wx3b55df6bdee5d3fe",
            'APPSECRET' => "fee6f919b912ee0de565387a9467c77a",
        ],
        'smser' => [
            // 微信支付
            'class' => 'extensions\wxzuanpay\Wxzuanpay',
        ]
    ],
];