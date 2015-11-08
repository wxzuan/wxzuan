<?php

namespace app\modules\member\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use frontend\models\forms\SearchProcessForm;

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
                        'actions' => ['index', 'buyed', 'rate'],
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
        return $this->render('product_index');
    }

    /**
     * 已购商品
     * @return type
     */
    public function actionBuyed() {
        return $this->render('product_buyed');
    }

    /**
     * 物流进度
     * @return type
     */
    public function actionRate() {

        $model = new SearchProcessForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $this->refresh();
            if ($resultR) {
                Yii::$app->session->setFlash('success', '更新成功');
                $this->redirect('/public/notices.html');
                Yii::$app->end();
            }
        } else {
            return $this->render('product_rate', ['model' => $model]);
        }
    }

}
