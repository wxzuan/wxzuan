<?php

namespace app\modules\member\controllers;

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
use frontend\modules\member\models\forms\UserInfoForm;
use common\models\Pic;
use yii\data\Pagination;
use yii\helpers\Url;

class UserController extends \common\controllers\BaseController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['info', 'changeimg', 'index', 'wechat','wechtchangeimg'],
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
    public function actionWechat() {
        $user = \Yii::$app->user->getIdentity();
        $post = \Yii::$app->request->post();
        //图片选择处理
        if (isset($post['User'])) {
            if (is_numeric($post['User']['card_pic2'])) {
                #获得图片
                $selectpic = Pic::find()->where('user_id=:user_id AND id=:id', [':user_id' => $user->user_id, ':id' => $post['User']['card_pic2']])->one();
                if ($selectpic) {
                    $user->setAttribute('card_pic2', $selectpic->pic_s_img);
                    if ($user->update()) {
                        $error = '更改成功';
                        $notices = array('type' => 2, 'msgtitle' => '操作成功', 'message' => $error, 'backurl' => Url::toRoute('/member/user/wechat'), 'backtitle' => '返回');
                        Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
                        $this->redirect(Url::toRoute('/public/notices'));
                        Yii::$app->end();
                    }
                }
            }
        }
        //获得头像类型图片
        $query = Pic::find()->where('user_id=:user_id AND pic_type=3', [':user_id' => $user->user_id])->orderBy(" id desc ");
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => '9']);
        $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        return $this->render('user_wechat', ['model' => $user, 'models' => $models, 'pages' => $pages]);
        \Yii::$app->end();
    }

    /**
     * 单个上传头像图片
     * @return type
     */
    public function actionWechtchangeimg() {
        $user = \Yii::$app->user->getIdentity();
        return $this->render('user_wechatchangeimg', ['model' => $user]);
    }
    public function actionIndex() {
        $user = \Yii::$app->user->getIdentity();
        $post = \Yii::$app->request->post();
        //图片选择处理
        if (isset($post['User'])) {
            if (is_numeric($post['User']['litpic'])) {
                #获得图片
                $selectpic = Pic::find()->where('user_id=:user_id AND id=:id', [':user_id' => $user->user_id, ':id' => $post['User']['litpic']])->one();
                if ($selectpic) {
                    $user->setAttribute('litpic', $selectpic->pic_s_img);
                    if ($user->update()) {
                        $error = '更改成功';
                        $notices = array('type' => 2, 'msgtitle' => '操作成功', 'message' => $error, 'backurl' => Url::toRoute('/member/user/index'), 'backtitle' => '返回');
                        Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
                        $this->redirect(Url::toRoute('/public/notices'));
                        Yii::$app->end();
                    }
                }
            }
        }
        //获得头像类型图片
        $query = Pic::find()->where('user_id=:user_id AND pic_type=1', [':user_id' => $user->user_id])->orderBy(" id desc ");
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => '9']);
        $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        return $this->render('user_index', ['model' => $user, 'models' => $models, 'pages' => $pages]);
        \Yii::$app->end();
    }

    /**
     * 单个上传头像图片
     * @return type
     */
    public function actionChangeimg() {
        $user = \Yii::$app->user->getIdentity();
        return $this->render('user_changeimg', ['model' => $user]);
    }
    /**
     * 用户基本信息
     * @return type
     */
    public function actionInfo() {
        $model = new UserInfoForm();
        $user = \Yii::$app->user->getIdentity();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->update($user)) {
                $this->refresh();
                $error = '更改成功';
                $notices = array('type' => 2, 'msgtitle' => '操作成功', 'message' => $error, 'backurl' => Url::toRoute('/member/index/index'), 'backtitle' => '返回会员中心');
                Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
                $this->redirect(Url::toRoute('/public/notices'));
                Yii::$app->end();
            }

            return $this->refresh();
        } else {
            $model->setAttributes($user->attributes);
            return $this->render('info', ['model' => $model]);
        }
    }
}
