<?php

namespace app\modules\member\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use frontend\models\forms\CashForm;
use \PDO;
use yii\helpers\Url;

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
                        'actions' => ['index', 'chongzhi', 'tixian', 'tixianlog', 'coupon'],
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
                'tourl' => Url::toRoute('/member/account/index/index'),
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

}
