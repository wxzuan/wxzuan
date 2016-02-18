<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\forms\PublishGiftMoneyForm;
use backend\models\forms\PublishGiftForm;

/**
 * Site controller
 */
class PublicController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'activity', 'publish','gift','coupon'],
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
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * 活动列表
     */
    public function actionActivity() {
        return $this->render('activity');
    }

    /**
     * 发布活动
     */
    public function actionGift() {
        $model = new PublishGiftForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->baseValition()) {
            if ($model->publish()) {
                $this->redirect('/public/activity.html');
            } else {
                return $this->render('publish', ['model' => $model]);
            }
        } else {
            return $this->render('gift', ['model' => $model]);
        }
    }

/**
     * 发布活动
     */

    public function actionCoupon() {
        $model = new PublishGiftMoneyForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->baseValition()) {
            if ($model->publish()) {
                $this->redirect('/public/activity.html');
            } else {
                return $this->render('publish', ['model' => $model]);
            }
        } else {
            return $this->render('publish', ['model' => $model]);
        }
    }

    /**
     * 发布活动
     */
    public function actionPublish() {
        $model = new PublishGiftMoneyForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->baseValition()) {
            if ($model->publish()) {
                $this->redirect('/public/activity.html');
            } else {
                return $this->render('publish', ['model' => $model]);
            }
        } else {
            return $this->render('publish', ['model' => $model]);
        }
    }

}
