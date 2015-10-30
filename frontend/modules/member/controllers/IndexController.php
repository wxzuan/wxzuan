<?php

namespace app\modules\member\controllers;

use yii\web\Controller;
use frontend\models\forms\UserBaseInfoForm;
use yii\widgets\ActiveForm;
use yii\web\Response;
use Yii;
use common\models\Bankcard;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class IndexController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['userinfo', 'index', 'sharp', 'bank'],
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
        $model = new UserBaseInfoForm();
        $user_id = Yii::$app->user->getId();
        $thisUser = User::find()->where("user_id=" . $user_id)->one();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($thisUser->real_status != 1) {
                $thisUser->setAttribute('realname', $model->realname);
                $thisUser->setAttribute('card_id', $model->card_id);
                $thisUser->setAttribute('real_status', 1);
            }
            if ($thisUser->phone != $model->phone) {
                $thisUser->setAttribute('phone', $model->phone);
                $thisUser->setAttribute('phone_status', 0);
            }
            if ($thisUser->email != $model->email) {
                $thisUser->setAttribute('email', $model->email);
                $thisUser->setAttribute('email_status', 0);
            }
            if ($thisUser->update()) {
                $this->refresh();
                Yii::$app->session->setFlash('success', '更新成功');
                $this->redirect('/public/notices.html');
                Yii::$app->end();
            }

            return $this->refresh();
        } else {
            $model->setAttributes($thisUser->attributes);
            return $this->render('userinfo', ['model' => $model]);
        }
    }

    /**
     * 我的银行
     */
    public function actionBank() {
        $model = new Bankcard();
        $user_id = Yii::$app->user->getId();
        $thisUser = Bankcard::find()->where("user_id=" . $user_id)->one();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            echo 11;exit;
//            if ($thisUser->real_status != 1) {
//                $thisUser->setAttribute('realname', $model->realname);
//                $thisUser->setAttribute('card_id', $model->card_id);
//                $thisUser->setAttribute('real_status', 1);
//            }
//            if ($thisUser->phone != $model->phone) {
//                $thisUser->setAttribute('phone', $model->phone);
//                $thisUser->setAttribute('phone_status', 0);
//            }
//            if ($thisUser->email != $model->email) {
//                $thisUser->setAttribute('email', $model->email);
//                $thisUser->setAttribute('email_status', 0);
//            }
//            if ($thisUser->update()) {
//                $this->refresh();
//                Yii::$app->session->setFlash('success', '更新成功');
//                $this->redirect('/public/notices.html');
//                Yii::$app->end();
//            }
//
//            return $this->refresh();
        } else {
            $model->setAttributes($thisUser->attributes);
            return $this->render('bank', ['model' => $model]);
        }
    }

}
