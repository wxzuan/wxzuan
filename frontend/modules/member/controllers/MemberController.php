<?php

namespace app\modules\member\controllers;

use yii\web\Controller;

class MemberController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
