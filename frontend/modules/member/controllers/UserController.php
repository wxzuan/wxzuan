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
                        'actions' => ['info', 'changeimg', 'index', 'sharp', 'bank', 'shippingaddress'],
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
