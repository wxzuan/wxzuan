<?php

namespace app\modules\wechat;

class wechatModule extends \yii\base\Module {

    public $controllerNamespace = 'app\modules\wechat\controllers';
    public $defaultRoute = 'api';

    public function init() {
        parent::init();
        \Yii::configure($this, require(__DIR__ . '/config.php'));
        // custom initialization code goes here
    }

}
