<?php

namespace app\modules\member\controllers;

use yii\web\Controller;
use frontend\models\forms\UserBaseInfoForm;
use yii\widgets\ActiveForm;
use yii\web\Response;
use Yii;

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
        $model = new UserBaseInfoForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            //} else {
            //   Yii::$app->session->setFlash('error', 'There was an error sending email.');
            //}

            return $this->refresh();
        } else {
            return $this->render('userinfo', ['model' => $model]);
        }
    }

}
