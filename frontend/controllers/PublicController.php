<?php

namespace frontend\controllers;

use common\models\User;
use common\models\LoginForm;
use Yii;
use yii\web\Request;
use yii\helpers\Html;

class PublicController extends \common\controllers\BaseController {

    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * 没有登录的提示页面
     * @return type
     */
    public function actionNologin() {
        return $this->render('nologin');
    }

    /**
     * 退出登录
     * @return type
     */
    public function actionLogout() {
        Yii::$app->user->logout();
        $this->redirect('/public/nologin.html');
    }

    /**
     * 登录控制
     * @return type
     */
    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            $this->redirect('/member/index.html');
        }
        $time = time();
        $time = $time - 10;
        if (!empty(\Yii::$app->request->get('id')) && !empty(\Yii::$app->request->get('stoken'))) {
            $user_id = \Yii::$app->request->get('id');
            $stoken = \Yii::$app->request->get('stoken');
//$user = Users::model()->find(" user_id=:id AND repstaken=:repstaken AND repsativetime>=:time", array(":id"=>$user_id,":repstaken" => $stoken, ":time" => $time));
 //echo $user_id;exit;
            $user = User::find()->where(" user_id=:id", [":id" => $user_id])->one();
//$user = User::model()->find(" user_id=:id", array(":id" => $user_id));
            if ($user) {
                $loginform = new LoginForm();
                $loginform->setAttributes([
                    'username' => $user->username,
                    'password' => $user->privacy,
                    'rememberMe' => true,
                ]);
                if ($loginform->login(2)) {
                    $this->redirect('/member/index.html');
                    \Yii::$app->end();
                }
            }
        }
        $this->redirect('/public/nologin.html');
    }

    /**
     * 提示信息
     */
    public function actionNotices() {
        return $this->render('notices');
    }

}
