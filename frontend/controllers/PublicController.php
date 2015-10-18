<?php

namespace frontend\controllers;

class PublicController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
