<?php

namespace app\modules\member\controllers;

use yii\web\Controller;

class IndexController extends Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * 快速分享
     * @return type
     */
    public function actionSharp() {
        return $this->render('sharp');
    }

    /**
     * 用户基本信息
     * @return type
     */
    public function actionUserinfo() {
        return $this->render('userinfo');
    }

}
