<?php

namespace app\modules\member;

class MemberModule extends \yii\base\Module {

    public $controllerNamespace = 'app\modules\member\controllers';

    public function init() {
        parent::init();
        $this->layout="l_member";
        // custom initialization code goes here
    }

}
