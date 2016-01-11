<?php

namespace frontend\controllers;

use frontend\models\forms\PublishlogisticsForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\UserProductAddress;
use common\models\Logistics;
use common\models\Account;
use yii\helpers\Url;
use \PDO;
use common\models\User;
use frontend\services\LogisticsService;

class LogisticsController extends \yii\web\Controller {

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
    public function actionPublishlogistics() {
        $model = new PublishlogisticsForm();
        $p_param = Yii::$app->request->get();
        $publishUser = User::find()->where("user_id=:user_id", [':user_id' => \Yii::$app->user->getId()])->one();
        if (!$publishUser->province || !$publishUser->city || !$publishUser->address) {
            $error = '您的地址没有完善，无法发布物流信息。';
            $notices = array('type' => 2, 'msgtitle' => '地址不正确', 'message' => $error, 'backurl' => Url::toRoute('/member/index/userinfo'), 'backtitle' => '完善个人信息');
            Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
            $this->redirect(Url::toRoute('/public/notices'));
        }
        $oneLogis = '';
        if (isset($p_param['id'])) {
            $oneLogis = Logistics::find()->where("id=:id", [':id' => $p_param['id']])->one();
            if ($oneLogis) {
                $model->setAttributes($oneLogis->attributes);
            }
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($oneLogis) {
                $logis_fee = $oneLogis->logis_fee;
                $logis_bail = $oneLogis->logis_bail;
                $oneLogis->setAttributes($model->attributes);
                if ($oneLogis->fee_lock != 0) {
                    $oneLogis->Attribute("logis_fee", $logis_fee);
                }
                if ($oneLogis->bail_lock != 0) {
                    $oneLogis->Attribute("logis_bail", $logis_bail);
                }
                if ($oneLogis->update()) {
                    $error = '更新成功,如已冻结佣金或者已冻结保证金,相应资金不能再修改.';
                    $notices = array('type' => 2, 'msgtitle' => '操作成功', 'message' => $error, 'backurl' => Url::toRoute('/logistics/publishlogistics/' . $oneLogis->id), 'backtitle' => '返回');
                    Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
                    $this->redirect(Url::toRoute('/public/notices'));
                } else {
                    return $this->render('publishlogistics', [
                                'model' => $model,
                    ]);
                }
            } else if ($model->save()) {
                $error = '添加成功,请添加物品图片';
                $pid = Yii::$app->db->getLastInsertID();
                $notices = array('type' => 2, 'msgtitle' => '操作成功', 'message' => $error, 'backurl' => Url::toRoute('/member/logistics/selectimg/' . $pid), 'backtitle' => '选择物品图片');
                Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
                $this->redirect(Url::toRoute('/public/notices'));
            } else {
                return $this->render('publishlogistics', [
                            'model' => $model,
                ]);
            }
        } else {
            return $this->render('publishlogistics', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * 添加商品
     */
    public function actionDetail() {
        $p_param = Yii::$app->request->get();
        $oneLogis = Logistics::find()->where("id=:id", [':id' => $p_param['id']])->one();
        if (!$oneLogis) {
            $error = '不存在此信息';
            $notices = array('type' => 2, 'msgtitle' => '错误的操作', 'message' => $error, 'backurl' => \Yii::$app->request->referrer, 'backtitle' => '返回');
            Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
            $this->redirect(Url::toRoute('/public/notices'));
        }

        return $this->render('logis_detail', [
                    'model' => $oneLogis,
        ]);
    }

    /**
     * 购买商品处理
     */
    public function actionVouch() {

        $this->view->title = "担保物品";
        $error = "";
        $backUrl = \Yii::$app->request->referrer;
        $p_param = Yii::$app->request->get();
        if (isset($p_param['id'])) {
            $pid = $p_param['id'];
            $logis = Logistics::find()->where("id=:id AND bail_lock=0 ", [':id' => $pid])->one();
            if ($logis) {
                #获得用户的可用资金
                $user_id = \Yii::$app->user->getId();
                if ($user_id == $logis->publis_user_id) {
                    $error = "不允许签约自己的物品。";
                    $notices = array('type' => 2, 'msgtitle' => '错误信息', 'message' => $error, 'backurl' => $backUrl, 'backtitle' => '返回');
                } else {
                    $userAccount = Account::find()->where("user_id=:user_id", [":user_id" => $user_id])->one();
                    if ($userAccount->use_money < $logis->logis_bail) {
                        $result = LogisticsService::lockLogisticsBail($user_id, $logis->id);
                        if ($result['status'] == 1) {
                            $error = '签约成功！';
                            $notices = array(
                                'type' => 3,
                                'msgtitle' => '操作成功',
                                'message' => $error,
                                'backurl' => $backUrl,
                                'backtitle' => '返回',
                                'tourl' => Url::toRoute('/member/logistics/booked'),
                                'totitle' => '查看签约'
                            );
                        } else {
                            $error = $result['remark'];
                            $notices = array('type' => 2, 'msgtitle' => '错误信息', 'message' => $error, 'backurl' => $backUrl, 'backtitle' => '返回');
                        }
                    } else {
                        #跳转到充值页面
                        $error = "你的可用资金不足以购买此商品。";
                        $notices = array(
                            'type' => 3,
                            'msgtitle' => '错误信息',
                            'message' => $error,
                            'backurl' => $backUrl,
                            'backtitle' => '返回',
                            'tourl' => Url::toRoute('/member/account/chongzhi'),
                            'totitle' => '前往充值'
                        );
                    }
                }
            } else {
                $error = "该物品已经被签约。";
                $notices = array('type' => 2, 'msgtitle' => '错误信息', 'message' => $error, 'backurl' => $backUrl, 'backtitle' => '返回');
            }
        } else {
            $error = "不存在此物品。";
            $notices = array('type' => 2, 'msgtitle' => '错误信息', 'message' => $error, 'backurl' => $backUrl, 'backtitle' => '返回');
        }
        #msg类型：type=1错误信息2指示跳转3返回跳转

        Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
        $this->redirect(Url::toRoute('/public/notices'));
    }

    /**
     * 显示可用资金
     */
    public function actionBook() {
        $user_id = \Yii::$app->user->getId();
        #获得用户的可用资金
        $p_param = Yii::$app->request->get();
        if (!isset($p_param['id'])) {
            echo 1;
            Yii::$app->end();
        }
        $logis = Logistics::find()->where("id=:id", [':id' => $p_param['id']])->one();
        if (!isset($logis)) {
            echo 1;
            Yii::$app->end();
        }
        if ($user_id == $logis->publis_user_id) {
            echo '<p>不允许签订自己的物品</p><button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>';
            Yii::$app->end();
        }
        $oneAccount = Account::find()->where("user_id=:user_id", [':user_id' => $user_id])->one();
        return $this->renderAjax('ajax_showUserMoney', ['oneAccount' => $oneAccount, 'logis' => $logis]);
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'addproduct', 'buy', 'showmymoney'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'publishlogistics', 'book', 'vouch', 'showmymoney'],
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
