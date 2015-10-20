<?php

namespace frontend\controllers;

use frontend\models\forms\AddProductForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ProductController extends \yii\web\Controller {

    /**
     * 商品列表
     * @return type
     */
    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * 添加商品
     */
    public function actionAddproduct() {
        $model = new AddProductForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            //} else {
            //   Yii::$app->session->setFlash('error', 'There was an error sending email.');
            //}

            return $this->refresh();
        } else {
            return $this->render('product_add', [
                        'model' => $model,
            ]);
        }
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'addproduct'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index','addproduct'],
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
}
