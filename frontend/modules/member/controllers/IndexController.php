<?php

namespace app\modules\member\controllers;

use frontend\models\forms\UserBaseInfoForm;
use \frontend\models\forms\BankForm;
use frontend\models\forms\UserProductAddressForm;
use yii\widgets\ActiveForm;
use yii\web\Response;
use Yii;
use common\models\Bankcard;
use common\models\UserProductAddress;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\Linkage;
use common\models\User;

class IndexController extends \common\controllers\BaseController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['userinfo', 'index', 'sharp', 'bank', 'shippingaddress'],
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
        $model = new BankForm();
        $user_id = Yii::$app->user->getId();
        $thisBank = Bankcard::find()->where("user_id=" . $user_id)->one();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $thisBank->setAttributes($model->attributes);
            $thisBank->setAttribute('province', $_POST['province']);
            $thisBank->setAttribute('city', $_POST['city']);
            $bank_name = Linkage::getValueChina("1002", "account_bank");
            $thisBank->setAttribute('bank_name', $bank_name);
            $resultR = $thisBank->save();
            $this->refresh();
            if ($resultR) {
                Yii::$app->session->setFlash('success', '更新成功');
                $this->redirect('/public/notices.html');
                Yii::$app->end();
            }
        } else {
            $model->setAttributes($thisBank->attributes);
            return $this->render('bank', ['model' => $model]);
        }
    }

    /**
     * 我的银行
     */
    public function actionShippingaddress() {
        $model = new UserProductAddressForm();
        $user_id = Yii::$app->user->getId();
        $thisuserpa = UserProductAddress::find()->where("user_id=" . $user_id)->one();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $thisuserpa->setAttributes($model->attributes);
            $thisuserpa->setAttribute('province', $_POST['province']);
            $thisuserpa->setAttribute('city', $_POST['city']);
            $thisuserpa->setAttribute('area', $_POST['area']);
            $address = Yii::$app->cache->get('sys_address');
            $sysaddress = $address['province'][$_POST['province']] . $address['city'][$_POST['city']] . $address['area'][$_POST['area']];
            $thisuserpa->setAttribute('sysaddress', $sysaddress);
            $resultR = $thisuserpa->save();
            $this->refresh();
            if ($resultR) {
                Yii::$app->session->setFlash('success', '更新成功');
                $this->redirect('/public/notices.html');
                Yii::$app->end();
            }
        } else {
            $model->setAttributes($thisuserpa->attributes);
            return $this->render('shippingaddress', ['model' => $model]);
        }
    }

}
