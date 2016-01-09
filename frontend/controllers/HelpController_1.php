<?php

namespace frontend\controllers;

class HelpController extends \yii\web\Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * 联系我们
     * @return type
     */
    public function actionContact() {
        return $this->render('contact');
    }

}
