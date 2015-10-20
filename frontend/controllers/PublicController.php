<?php

namespace frontend\controllers;

class PublicController extends \yii\web\Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * 没有登录的提示页面
     * @return type
     */
    public function actionNologin() {
        return $this->render('nologin');
    }

}
