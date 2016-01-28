<?php

namespace app\modules\member\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use frontend\models\forms\SearchProcessForm;
use common\models\Logistics;
use common\models\Pic;
use yii\data\Pagination;
use yii\helpers\Url;
use common\models\ProductOrder;
use frontend\services\LogisticsService;
use \PDO;

class LogisticsController extends \common\controllers\BaseController {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['mybook', 'mygift', 'index', 'booked', 'rate', 'changeimg', 'selectimg', 'fitlogs', 'fititem', 'suresellproduct', 'cancelsellproduct', 'successbuy'],
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
     * 处理订货
     */
    public function actionFitlogs() {
        $param_get=\Yii::$app->request->get();
        LogisticsService::fitLogs($this,$param_get);
        \Yii::$app->end();
    }

    /**
     * 默认为我的物品列表
     * @return type
     */
    public function actionIndex() {
        $params_get = \Yii::$app->request->get();
        if (isset($params_get['ac']) && isset($params_get['id'])) {
            LogisticsService::fitIndexAC($params_get);
        } else {
            return $this->render('logistics_index');
        }
    }

    /**
     * 默认为我的订单列表
     * @return type
     */
    public function actionMybook() {
        return $this->render('logistics_book');
    }

    /**
     * 默认为我的收物列表
     * @return type
     */
    public function actionMygift() {
        return $this->render('logistics_gift');
    }

    /**
     * 已购商品
     * @return type
     */
    public function actionBooked() {
        return $this->render('logistics_booked');
    }

    /**
     * 物流进度
     * @return type
     */
    public function actionRate() {
        $p_param = \Yii::$app->request->get();
        if (isset($p_param['id'])) {
            echo '<p>该功能未开放</p><button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>';
            \Yii::$app->end();
        }
        $model = new SearchProcessForm();

        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {

            $this->refresh();
            if ($resultR) {
                \Yii::$app->session->setFlash('success', '更新成功');
                $this->redirect('/public/notices.html');
                \Yii::$app->end();
            }
        } else {
            return $this->render('product_rate', ['model' => $model]);
        }
    }

    /**
     * 选择商品图片
     * @return type
     */
    public function actionSelectimg() {
        $p_param = \Yii::$app->request->get();
        $user_id = \Yii::$app->user->getId();
        if (isset($p_param['id'])) {
            $oneLogistics = Logistics::find()->where("id=:id", [':id' => $p_param['id']])->one();
            if ($oneLogistics) {
                //图片选择处理
                if (isset($_POST['Logistics'])) {
                    if (is_numeric($_POST['Logistics']['logis_s_img'])) {
                        #获得图片
                        $selectpic = Pic::find()->where('user_id=:user_id AND id=:id', [':user_id' => $user_id, ':id' => $_POST['Logistics']['logis_s_img']])->one();
                        if ($selectpic) {
                            $oneLogistics->setAttribute('logis_s_img', $selectpic->pic_s_img);
                            $oneLogistics->setAttribute('logis_m_img', $selectpic->pic_m_img);
                            $oneLogistics->setAttribute('logis_b_img', $selectpic->pic_b_img);
                            if ($oneLogistics->update()) {
                                $error = '更改成功';
                                $notices = array('type' => 2, 'msgtitle' => '操作成功', 'message' => $error, 'backurl' => Url::toRoute('/member/logistics/index'), 'backtitle' => '返回');
                                \Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
                                $this->redirect(Url::toRoute('/public/notices'));
                                \Yii::$app->end();
                            }
                        }
                    }
                }
                $query = Pic::find()->where('user_id=:user_id AND pic_type=2', [':user_id' => $user_id])->orderBy(" id desc ");
                $countQuery = clone $query;
                $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => '9']);
                $models = $query->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
                return $this->render('logistics_selectimg', ['model' => $oneLogistics, 'models' => $models, 'pages' => $pages]);
                \Yii::$app->end();
            }
        }
        $error = '不存在此信息';
        $notices = array('type' => 2, 'msgtitle' => '错误的操作', 'message' => $error, 'backurl' => Url::toRoute('/member/logistics/index'), 'backtitle' => '返回');
        \Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
        $this->redirect(Url::toRoute('/public/notices'));
    }

    /**
     * 单个商品修改
     * @return type
     */
    public function actionChangeimg() {
        $p_param = \Yii::$app->request->get();
        if (isset($p_param['id'])) {
            $oneLogistics = Logistics::find()->where("id=:id", [':id' => $p_param['id']])->one();
            if ($oneLogistics) {
                return $this->render('logistics_changeimg', ['model' => $oneLogistics]);
                \Yii::$app->end();
            }
        }
        $error = '不存在此物品';
        $notices = array('type' => 2, 'msgtitle' => '错误的操作', 'message' => $error, 'backurl' => Url::toRoute('/member/logistics/index'), 'backtitle' => '返回');
        \Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
        $this->redirect(Url::toRoute('/public/notices'));
    }

    /**
     * 单个商品修改
     * @return type
     */
    public function actionCancelsellproduct() {
        $user_id = \Yii::$app->user->getId();
        #获得用户的可用资金
        $p_param = \Yii::$app->request->get();
        if (!isset($p_param['id'])) {
            echo 1;
            \Yii::$app->end();
        }
        $order = ProductOrder::find()->where("order_id=:id AND p_user_id=:user_id ", [':id' => $p_param['id'], ':user_id' => $user_id])->one();
        if (!isset($order)) {
            echo 1;
            \Yii::$app->end();
        }
        if (isset($p_param['sure']) && $p_param['sure'] == 1) {

            #调有存储过程冻结资金并生成订单
            try {
                $addip = \Yii::$app->request->userIP;
                $in_p_user_id = $order->p_user_id;
                $order_id = $order->order_id;
                $conn = Yii::$app->db;
                $command = $conn->createCommand('call p_cancel_Product_Order(:in_p_user_id,:order_id,:in_addip,@out_status,@out_remark)');
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
        return $this->renderAjax('ajax_cancelsell', ['order' => $order, 'p_param' => $p_param, 'fit' => $fit]);
    }

    /**
     * 单个商品修改
     * @return type
     */
    public function actionSuresellproduct() {
        $user_id = \Yii::$app->user->getId();
        #获得用户的可用资金
        $p_param = \Yii::$app->request->get();
        if (!isset($p_param['id'])) {
            echo 1;
            \Yii::$app->end();
        }
        $order = ProductOrder::find()->where("order_id=:id AND p_user_id=:user_id ", [':id' => $p_param['id'], ':user_id' => $user_id])->one();
        if (!isset($order)) {
            echo 1;
            \Yii::$app->end();
        }
        if (isset($p_param['sure']) && $p_param['sure'] == 1) {
            $in_p_user_id = $order->p_user_id;
            $order_id = $order->order_id;
            #调有存储过程冻结资金并生成订单
            $conn = \Yii::$app->db;
            $trance = $conn->beginTransaction();
            try {

                $command = $conn->createCommand('update ' . ProductOrder::tableName() . ' set order_status=1 where p_user_id=:in_p_user_id AND order_id=:order_id');
                $command->bindParam(":in_p_user_id", $in_p_user_id, PDO::PARAM_INT);
                $command->bindParam(":order_id", $order_id, PDO::PARAM_INT);
                $command->execute();
                $trance->commit();
                $fit = ['remark' => '发货成功', 'status' => 1];
            } catch (Exception $e) {
                $trance->rollBack();
                $fit = ['remark' => '发货失败', 'status' => 0];
            }
        } else {
            $fit = [];
        }
        return $this->renderAjax('ajax_suresell', ['order' => $order, 'p_param' => $p_param, 'fit' => $fit]);
    }

    /**
     * 单个商品修改
     * @return type
     */
    public function actionSuccessbuy() {
        $user_id = \Yii::$app->user->getId();
        #获得用户的可用资金
        $p_param = \Yii::$app->request->get();
        if (!isset($p_param['id'])) {
            echo 1;
            \Yii::$app->end();
        }
        $order = ProductOrder::find()->where("order_id=:id AND user_id=:user_id ", [':id' => $p_param['id'], ':user_id' => $user_id])->one();
        if (!isset($order)) {
            echo 1;
            \Yii::$app->end();
        }
        if (isset($p_param['sure']) && $p_param['sure'] == 1) {

            #调有存储过程冻结资金并生成订单
            try {
                $addip = \Yii::$app->request->userIP;
                $in_p_user_id = $order->user_id;
                $order_id = $order->order_id;
                $conn = \Yii::$app->db;
                $command = $conn->createCommand('call p_success_Product_Order(:in_p_user_id,:order_id,:in_addip,@out_status,@out_remark)');
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
        return $this->renderAjax('ajax_successbuy', ['order' => $order, 'p_param' => $p_param, 'fit' => $fit]);
    }

    /**
     * 处理货物
     */
    public function actionFititem() {
        return $this->render("product_fititem");
    }

}

