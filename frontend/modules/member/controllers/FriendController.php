<?php

namespace app\modules\member\controllers;

use yii\widgets\ActiveForm;
use yii\web\Response;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use frontend\modules\member\models\forms\AddFriendForm;

class FriendController extends \common\controllers\BaseController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [ 'index', 'addfriend'],
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
        return $this->render('friend');
    }

    /**
     * 添加好友
     * @return type
     */
    public function actionAddfriend() {

        $model = new AddFriendForm();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->addFriend()) {
                $this->refresh();
                $this->redirect('/member/friend/index.html');
                Yii::$app->end();
            }
        } else {
            return $this->render('addfriend', ['model' => $model]);
        }
    }

}
