<?php

namespace app\modules\member\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ProductController extends \common\controllers\BaseController {

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
     * 默认为我的商品列表
     * @return type
     */
    public function actionIndex() {
        return $this->render('account_index');
    }

    /**
     * 已购商品
     * @return type
     */
    public function actionBuyed() {
        return $this->render('account_index');
    }

    /**
     * 物流进度
     * @return type
     */
    public function actionRate() {
        return $this->render('account_index');
    }

}
