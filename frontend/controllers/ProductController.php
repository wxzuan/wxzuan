<?php

namespace frontend\controllers;

use frontend\models\forms\AddProductForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\UserProductAddress;
use common\models\Product;
use common\models\Account;

class ProductController extends \yii\web\Controller {

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
    public function actionAddproduct() {
        $model = new AddProductForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            //if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            //} else {
            //   Yii::$app->session->setFlash('error', 'There was an error sending email.');
            //}

            return $this->refresh();
        } else {
            return $this->render('product_add', [
                        'model' => $model,
            ]);
        }
    }

    public function actionBuy() {

        $this->pageTitle = "购买商品";
        $error = "";
        if (isset($_GET['id'])) {
            $pid = $_GET['id'];
            $product = Product::find("product_id=:id",[':id'=>$pid])->one();
            if ($product) {
                #获得用户的可用资金
                $user_id = \Yii::$app->user->getId();
                #判断用户是否已经填写了送货地址
                $userAddress = UserProudctAddress::find("user_id=:user_id", array(":user_id" => $user_id))->one();
                if ($userAddress) {
                    $userAccount = Account::find("user_id=:user_id", array(":user_id" => $user_id))->one();
                    if (!$userAccount->use_money < $product->product_price) {
                        #调有存储过程冻结资金并生成订单
                        try {
                            $addip = \Yii::$app->request->userIP;
                            $in_order_price = $in_order_pay_price = $product->product_price;
                            $in_coupon_id = 0;
                            $in_p_user_id = $product->product_user_id;
                            $p_id = $product->product_id;
                            $in_realname = $userAddress->realname;
                            $in_phone = $userAddress->phone;
                            $in_address = $userAddress->address;
                            $conn = Yii::$app->db;
                            $command = $conn->createCommand('call p_build_Product_Order(:in_user_id,:in_p_user_id,:p_id,:in_order_price,:in_order_pay_price,:in_coupon_id,:in_realname,:in_phone,:in_address,:in_addip,@out_status,@out_remark)');
                            $command->bindParam(":in_user_id", $user_id, PDO::PARAM_INT);
                            $command->bindParam(":in_p_user_id", $in_p_user_id, PDO::PARAM_INT);
                            $command->bindParam(":p_id", $p_id, PDO::PARAM_INT);
                            $command->bindParam(":in_order_price", $in_order_price, PDO::PARAM_STR, 30);
                            $command->bindParam(":in_order_pay_price", $in_order_pay_price, PDO::PARAM_STR, 30);
                            $command->bindParam(":in_coupon_id", $in_coupon_id, PDO::PARAM_INT);
                            $command->bindParam(":in_realname", $in_realname, PDO::PARAM_STR, 30);
                            $command->bindParam(":in_phone", $in_phone, PDO::PARAM_STR, 30);
                            $command->bindParam(":in_address", $in_address, PDO::PARAM_STR, 200);
                            $command->bindParam(":in_addip", $addip, PDO::PARAM_STR, 50);
                            $command->execute();
                            $result = $conn->createCommand("select @out_status as status,@out_remark as remark")->queryRow(true);
                            if ($result['status'] == 1) {
                                $error = '购买成功！';
                                $notices = array(
                                    'type' => 3,
                                    'msgtitle' => '错误信息',
                                    'message' => $error,
                                    'backurl' => \Yii::$app->request->urlReferrer,
                                    'backtitle' => '返回',
                                    'tourl' => \Yii::$app->createUrl('/wechat/member/myProduct'),
                                    'totitle' => '查看订单'
                                );
                            } else {
                                $error = $result['remark'];
                                $notices = array('type' => 2, 'msgtitle' => '错误信息', 'message' => $error, 'backurl' => Yii::app()->request->urlReferrer, 'backtitle' => '返回');
                            }
                        } catch (Exception $e) {
                            $error = '系统繁忙，暂时无法处理';
                            $notices = array('type' => 2, 'msgtitle' => '错误信息', 'message' => $error, 'backurl' => Yii::app()->request->urlReferrer, 'backtitle' => '返回');
                        }
                    } else {
                        #跳转到充值页面
                        $error = "你的可用资金不足以购买此商品。";
                        $notices = array(
                            'type' => 3,
                            'msgtitle' => '错误信息',
                            'message' => $error,
                            'backurl' => Yii::app()->request->urlReferrer,
                            'backtitle' => '返回',
                            'tourl' => Yii::app()->createUrl('/wechat/member/addmoney'),
                            'totitle' => '前往充值'
                        );
                    }
                } else {
                    #跳转到充值页面
                    $error = "您没有填写收货地址。";
                    $notices = array(
                        'type' => 3,
                        'msgtitle' => '错误信息',
                        'message' => $error,
                        'backurl' => Yii::app()->request->urlReferrer,
                        'backtitle' => '返回',
                        'tourl' => Yii::app()->createUrl('/wechat/member/proAddress'),
                        'totitle' => '完善送货地址'
                    );
                }
            } else {
                $error = "不存在此商品或者该商品已下架。";
                $notices = array('type' => 2, 'msgtitle' => '错误信息', 'message' => $error, 'backurl' => Yii::app()->request->urlReferrer, 'backtitle' => '返回');
            }
        } else {
            $error = "不存在此商品或者该商品已下架。";
            $notices = array('type' => 2, 'msgtitle' => '错误信息', 'message' => $error, 'backurl' => Yii::app()->request->urlReferrer, 'backtitle' => '返回');
        }
        #msg类型：type=1错误信息2指示跳转3返回跳转

        Yii::app()->user->setFlash('wechat_fail', array($notices));
        $this->redirect(Yii::app()->createUrl('wechat/notice/errors'));
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'addproduct','buy'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'addproduct','buy'],
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
