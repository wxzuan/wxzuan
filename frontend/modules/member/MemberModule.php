<?php

namespace app\modules\member;

class MemberModule extends \yii\base\Module {

    public $controllerNamespace = 'app\modules\member\controllers';

    public function init() {
        parent::init();
        $this->defaultRoute='member';
        // custom initialization code goes here
    }

}
