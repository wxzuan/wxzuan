<?php

namespace app\modules\member\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use frontend\models\forms\SearchProcessForm;

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
                        'actions' => ['index','chongzhi','tixian'],
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

    /**
     * 充值操作
     * @return type
     */
    public function actionChongzhi() {
        return $this->render('account_chongzhi');
    }

    /**
     * 提现操作
     * @return type
     */
    public function actionTixian() {
        $model = new SearchProcessForm();
        return $this->render('account_tixian', ['model' => $model]);
    }

}
