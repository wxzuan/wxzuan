<?php

namespace app\modules\member\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class AccountController extends \common\controllers\BaseController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * 默认为资金记录
     * @return type
     */
    public function actionIndex() {
        return $this->render('account_index');
    }

}
