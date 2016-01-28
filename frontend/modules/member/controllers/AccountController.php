<?php

namespace app\modules\member\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use frontend\models\forms\CashForm;
use \PDO;
use yii\helpers\Url;
use common\models\tableviews\ViewGifts;
use common\models\Cash;

class AccountController extends \common\controllers\BaseController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'chongzhi', 'tixian', 'tixianlog', 'coupon', 'getgift'],
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
     * 默认为资金记录
     * @return type
     */
    public function actionIndex() {
        return $this->render('account_index');
    }

    /**
     * 充值操作
     * @return type
     */
    public function actionChongzhi() {
        return $this->render('account_chongzhi');
    }

    /**
     * 取消提现
     */
    public function actionCancelcash() {
        $user_id = \Yii::$app->user->getId();
        #获得用户的可用资金
        $p_param = Yii::$app->request->get();
        if (!isset($p_param['id'])) {
            echo 1;
            Yii::$app->end();
        }
        $order = Cash::find()->where("id=:id AND user_id=:user_id AND status=0 ", [':id' => $p_param['id'], ':user_id' => $user_id])->one();
        if (!isset($order)) {
            echo '<p>数据已经处理过。</p><button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>';
            Yii::$app->end();
        }
        if (isset($p_param['sure']) && $p_param['sure'] == 1) {
#调有存储过程取消提现
            try {
                $addip = \Yii::$app->request->userIP;
                $in_p_user_id = $order->user_id;
                $order_id = $order->id;
                $conn = Yii::$app->db;
                $command = $conn->createCommand('call p_Cancel_Cash(:in_p_user_id,:order_id,:in_addip,@out_status,@out_remark)');
                $command->bindParam(":in_p_user_id", $in_p_user_id, PDO::PARAM_INT);
                $command->bindParam(":order_id", $order_id, PDO::PARAM_INT);
                $command->bindParam(":in_addip", $addip, PDO::PARAM_STR, 50);
                $command->execute();
                $fit = $conn->createCommand("select @out_status as status,@out_remark as remark")->queryOne();
            } catch (Exception $e) {
                $fit = ['remark' => '系统繁忙，暂时无法处理', 'status' => 0];
            }
        } else {
            $fit = [];
        }
        return $this->renderAjax('ajax_surecash', ['order' => $order, 'p_param' => $p_param, 'fit' => $fit]);
    }

    /**
     * 提现操作
     * @return type
     */
    public function actionTixian() {
        $model = new CashForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            #调有存储过程冻结资金并生成订单
            try {
                $addip = \Yii::$app->request->userIP;
                $user_id = \Yii::$app->user->getId();
                $money = $model->money;
                $conn = \Yii::$app->db;
                $command = $conn->createCommand('call p_apply_Cash(:in_p_user_id,:money,:in_addip,@out_status,@out_remark)');
                $command->bindParam(":in_p_user_id", $user_id, PDO::PARAM_INT);
                $command->bindParam(":money", $money, PDO::PARAM_STR);
                $command->bindParam(":in_addip", $addip, PDO::PARAM_STR, 50);
                $command->execute();
                $fit = $conn->createCommand("select @out_status as status,@out_remark as remark")->queryOne();
            } catch (Exception $e) {
                $fit = ['remark' => '系统繁忙，暂时无法处理', 'status' => 0];
            }
            if ($fit['status'] == 0) {
                $msgtitle = '操作失败';
            } else {
                $msgtitle = '操作成功';
            }
            $notices = array(
                'type' => 3,
                'msgtitle' => $msgtitle,
                'message' => $fit['remark'],
                'backurl' => Url::toRoute('/member/account/tixian'),
                'backtitle' => '返回',
                'tourl' => Url::toRoute('/member/account/index'),
                'totitle' => '会员中心'
            );
            \Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
            $this->redirect(Url::toRoute('/public/notices'));
            \Yii::$app->end();
        } else {
            return $this->render('account_tixian', ['model' => $model]);
        }
    }

    /**
     * 提现记录
     * @return type
     */
    public function actionTixianlog() {
        return $this->render('account_tixianlog');
    }

    /**
     * 
     * @return type
     */
    public function actionCoupon() {
        return $this->render('account_coupon');
    }

    /**
     * 
     * @return type
     */
    public function actionGetgift() {

        $user_id = \Yii::$app->user->getId();
        #获得用户的可用资金
        $p_param = \Yii::$app->request->get();
        if (!isset($p_param['id']) || !isset($p_param['type'])) {
            echo 1;
            Yii::$app->end();
        }
        $gift = ViewGifts::find()->where("id=:id AND user_id=:user_id AND ac_type=:type AND LENGTH(fittime)<5", [':id' => $p_param['id'], ':user_id' => $user_id, ':type' => $p_param['type']])->one();
        if (!isset($gift)) {
            echo 1;
            \Yii::$app->end();
        }
        if (isset($p_param['sure']) && $p_param['sure'] == 1) {
            $in_p_user_id = $gift->user_id;
            $id = $gift->id;
            #调有存储过程冻结资金并生成订单
            $conn = \Yii::$app->db;
            $trance = $conn->beginTransaction();
            try {

                $addip = \Yii::$app->request->userIP;
                $user_id = \Yii::$app->user->getId();
                $conn = \Yii::$app->db;
                $command = $conn->createCommand('call p_get_Gift(:in_p_user_id,:id,:in_addip,@out_status,@out_remark)');
                $command->bindParam(":in_p_user_id", $user_id, PDO::PARAM_INT);
                $command->bindParam(":id", $id, PDO::PARAM_STR);
                $command->bindParam(":in_addip", $addip, PDO::PARAM_STR, 50);
                $command->execute();
                $fit = $conn->createCommand("select @out_status as status,@out_remark as remark")->queryOne();
            } catch (Exception $e) {
                $trance->rollBack();
                $fit = ['remark' => '领取失败', 'status' => 0];
            }
        } else {
            $fit = [];
        }
        return $this->renderAjax('ajax_getgift', ['order' => $gift, 'p_param' => $p_param, 'fit' => $fit]);
    }

}
