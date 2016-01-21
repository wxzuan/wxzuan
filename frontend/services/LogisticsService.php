<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author qinyangsheng
 */

namespace frontend\services;

use common\models\Logistics;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use \Yii;
use \PDO;
use yii\helpers\Url;
use app\modules\member\controllers\LogisticsController;

class LogisticsService {

    /**
     * 
     * @param type $object
     * @param \frontend\services\User $weixinuser
     * @param type $data
     * @return string
     */
    public static function fitGetCode($object, User $weixinuser, $data) {
        $logis_id = $data[1];
        $token = urldecode($data[2]);
        //判断这个ID是否已经被处理过了
        $logs = Logistics::findOne($logis_id);
        if (!$logs || $logs->bail_lock != 0) {
            $content = '该信息不存在或者已经被接单。';
        } else {
            //解密数据
            $jsonstring = \Yii::$app->security->decryptByKey($token, $logs->hash_key);
            $fitdata = json_decode($jsonstring);
            if ($fitdata->tokenstring != $logs->hash_key) {
                $content = '密钥对应不上，不能进行操作。';
            } else {
                try {
                    $addip = '0.0.0.0';
                    $conn = \Yii::$app->db;
                    $command = $conn->createCommand('call p_finish_logis(:logis_id,:in_addip,@out_status,@out_remark)');
                    $command->bindParam(":logis_id", $logis_id, PDO::PARAM_INT);
                    $command->bindParam(":in_addip", $addip, PDO::PARAM_STR, 50);
                    $command->execute();
                    $result = $conn->createCommand("select @out_status as status,@out_remark as remark")->queryOne();
                } catch (Exception $e) {
                    $result = ['status' => 0, 'remark' => '系统繁忙，暂时无法处理'];
                }
                $content = $result['remark'];
                if ($result['status'] == 1) {
                    $content = '成功收取【 ' . Html::encode($logs->logis_name) . ' 】';
                }
            }
        }
        return $content;
    }

    /**
     * 
     * @param type $object
     * @param \frontend\services\User $weixinuser
     * @param type $data
     * @return string
     */
    public static function fitOutCode($object, User $weixinuser, $data) {
        $logis_id = $data[1];
        $token = urldecode($data[2]);
        //判断这个ID是否已经被处理过了
        $logs = Logistics::findOne($logis_id);
        if (!$logs || $logs->bail_lock != 0) {
            $content = '该信息不存在或者已经被接单。';
        } else {
            //解密数据
            $jsonstring = \Yii::$app->security->decryptByKey($token, $logs->hash_key);
            $fitdata = json_decode($jsonstring);
            if ($fitdata->tokenstring != $logs->hash_key) {
                $content = '密钥对应不上，不能进行操作。';
            } else {
                $user_id = $weixinuser->user_id;
                try {
                    $addip = '0.0.0.0';
                    $conn = \Yii::$app->db;
                    $command = $conn->createCommand('call p_lock_logis_Bail(:in_user_id,:logis_id,:in_addip,@out_status,@out_remark)');
                    $command->bindParam(":in_user_id", $user_id, PDO::PARAM_INT);
                    $command->bindParam(":logis_id", $logis_id, PDO::PARAM_INT);
                    $command->bindParam(":in_addip", $addip, PDO::PARAM_STR, 50);
                    $command->execute();
                    $result = $conn->createCommand("select @out_status as status,@out_remark as remark")->queryOne();
                } catch (Exception $e) {
                    $result = ['status' => 0, 'remark' => '系统繁忙，暂时无法处理'];
                }
                $content = $result['remark'];
                if ($result['status'] == 1) {
                    $content = '担保【 ' . Html::encode($logs->logis_name) . ' 】成功,冻结担保金【 ' . round($logs->logis_bail, 2) . ' 】元,完成送货可获得佣金【 ' . round($logs->logis_fee, 2) . ' 】元';
                }
            }
        }
        return $content;
    }

    /**
     * 处理订单问题
     * @param \app\modules\member\controllers\LogisticsController $con
     * @param type $param_get
     */
    public static function fitLogs(LogisticsController $con, $param_get = array()) {

        //不存在ID直接跳转到错误的页面
        if (!isset($param_get['id']) || empty($param_get['id']) || !isset($param_get['token']) || empty($param_get['token'])) {
            $error = '错误的操作';
            $notices = array('type' => 2, 'msgtitle' => '错误的操作', 'message' => $error, 'backurl' => Url::toRoute('/member/index/index'), 'backtitle' => '返回');
            \Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
            $con->redirect(Url::toRoute('/public/notices'));
            \Yii::$app->end();
        }
        $logis_id = $param_get['id'];
        $token = $param_get['token'];
        //判断这个ID是否已经被处理过了
        $logs = Logistics::findOne($logis_id);
        if (!$logs || $logs->bail_lock != 0) {
            $error = '该信息不存在或者已经被接单。';
            $notices = array('type' => 2, 'msgtitle' => '错误的操作', 'message' => $error, 'backurl' => Url::toRoute('/member/index/index'), 'backtitle' => '返回');
            \Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
            $con->redirect(Url::toRoute('/public/notices'));
            \Yii::$app->end();
        }
        //解密数据
        $jsonstring = \Yii::$app->security->decryptByKey($token, $logs->hash_key);
        $fitdata = json_decode($jsonstring);
        if ($fitdata->tokenstring != $logs->hash_key) {
            $error = '密钥对应不上，不能进行操作。';
            $notices = array('type' => 2, 'msgtitle' => '错误的操作', 'message' => $error, 'backurl' => Url::toRoute('/member/index/index'), 'backtitle' => '返回');
            \Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
            $con->redirect(Url::toRoute('/public/notices'));
            \Yii::$app->end();
        } else {
            $user = \Yii::$app->user->getIdentity();
            $user_id = $user->user_id;
            try {
                $addip = \Yii::$app->request->userIP;
                $conn = \Yii::$app->db;
                $command = $conn->createCommand('call p_lock_logis_Bail(:in_user_id,:logis_id,:in_addip,@out_status,@out_remark)');
                $command->bindParam(":in_user_id", $user_id, PDO::PARAM_INT);
                $command->bindParam(":logis_id", $logis_id, PDO::PARAM_INT);
                $command->bindParam(":in_addip", $addip, PDO::PARAM_STR, 50);
                $command->execute();
                $result = $conn->createCommand("select @out_status as status,@out_remark as remark")->queryOne();
            } catch (Exception $e) {
                $result = ['status' => 0, 'remark' => '系统繁忙，暂时无法处理'];
            }
            $error = $result['remark'];
            $msgtitle = '错误的操作';
            if ($error['status'] == 1) {
                $msgtitle = '担保成功！';
            }
            $notices = array('type' => 2, 'msgtitle' => $msgtitle, 'message' => $error, 'backurl' => Url::toRoute('/member/index/index'), 'backtitle' => '返回');
            \Yii::$app->getSession()->setFlash('wechat_fail', array($notices));
            $con->redirect(Url::toRoute('/public/notices'));
            \Yii::$app->end();
        }
    }

    public static function fitIndexAC($data = array()) {
        $user = \Yii::$app->user->getIdentity();
        switch ($data['ac']) {
            #删除一个信息
            case 'del':
                $result = Logistics::deleteAll("publis_user_id=:user_id AND fee_lock=0 and id=:id", [':user_id' => $user->user_id, ':id' => $data['id']]);
                if ($result) {
                    echo '<p>删除成功！</p><button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button><script type="text/javascript">("#fit_gift_' . $data['id'] . '").parent().parent().remove();</script>';
                } else {
                    echo '<p>删除失败</p><button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>';
                }
                Yii::$app->end();
                break;
            case 'outcode':
                #生成唯一标识TOOKENID
                $tokenString = \Yii::$app->security->generateRandomString();
                $setFlashString = ['user_id' => $user->user_id, 'id' => $data['id'], 'tokenstring' => $tokenString];
                Logistics::updateAll(['hash_key' => $tokenString], "publis_user_id=:user_id AND bail_lock=0 and id=:id", [':user_id' => $user->user_id, ':id' => $data['id']]);
                Yii::$app->session->setFlash('userbookingstring', $setFlashString);
                echo '<p><h3>请扫描二维码以确认收货</h3><img style="margin:0 auto;" src="' . Url::toRoute('/qrcode/bookcode') . '"/></p><button type="button" class="btn btn-danger pull-right" data-dismiss="modal">关闭</button>';
                Yii::$app->end();
                break;
            case 'getcode':
                #生成唯一标识TOOKENID
                $tokenString = \Yii::$app->security->generateRandomString();
                $setFlashString = ['user_id' => $user->user_id, 'id' => $data['id'], 'tokenstring' => $tokenString];
                Logistics::updateAll(['hash_key' => $tokenString], "to_user_id=:user_id AND bail_lock=1 and id=:id", [':user_id' => $user->user_id, ':id' => $data['id']]);
                Yii::$app->session->setFlash('userbookingstring', $setFlashString);
                echo '<p><h3>请扫描二维码以确认收货</h3><img style="margin:0 auto;" src="' . Url::toRoute('/qrcode/getcode') . '"/></p><button type="button" class="btn btn-danger pull-right" data-dismiss="modal">关闭</button>';
                Yii::$app->end();
                break;
            default : break;
        }
    }

    /**
     * 签约物流冻结保证金
     * @return boolean
     */
    public static function lockLogisticsBail($user_id, $logis_id) {
        try {
            $addip = \Yii::$app->request->userIP;
            $conn = \Yii::$app->db;
            $command = $conn->createCommand('call p_lock_logis_Bail(:in_user_id,:logis_id,:in_addip,@out_status,@out_remark)');
            $command->bindParam(":in_user_id", $user_id, PDO::PARAM_INT);
            $command->bindParam(":logis_id", $logis_id, PDO::PARAM_INT);
            $command->bindParam(":in_addip", $addip, PDO::PARAM_STR, 50);
            $command->execute();
            $result = $conn->createCommand("select @out_status as status,@out_remark as remark")->queryOne();
            return $result;
        } catch (Exception $e) {
            $result = ['status' => 0, 'remark' => '系统繁忙，暂时无法处理'];
            return $result;
        }
    }

    /**
     * 发布物流冻结佣金
     * @return boolean
     */
    public static function lockLogisticsFee($user_id, $logis_id) {
        try {
            $addip = \Yii::$app->request->userIP;
            $conn = \Yii::$app->db;
            $command = $conn->createCommand('call p_lock_logis_Fee(:in_user_id,:logis_id,:in_addip,@out_status,@out_remark)');
            $command->bindParam(":in_user_id", $user_id, PDO::PARAM_INT);
            $command->bindParam(":logis_id", $logis_id, PDO::PARAM_INT);
            $command->bindParam(":in_addip", $addip, PDO::PARAM_STR, 50);
            $command->execute();
            $result = $conn->createCommand("select @out_status as status,@out_remark as remark")->queryOne();
            return $result;
        } catch (Exception $e) {
            $result = ['status' => 0, 'remark' => '系统繁忙，暂时无法处理'];
            return $result;
        }
    }

    /**
     * 
     * @param int $data
     * @return \yii\data\ActiveDataProvider
     */
    public static function findLogisticss($data = array()) {
        if (!isset($data['limit'])) {
            $data['limit'] = 10;
        }
        $model = new Logistics();
        $dataProvider = new ActiveDataProvider([
            'query' => $model->find()->Where('logis_realarrivetime=0 AND fee_lock=:fee_lock', [':fee_lock' => $data['fee_lock']])->orderBy(" id desc ")->limit($data['limit']),
            'pagination' => [
                'pagesize' => $data['limit'],
            ]
        ]);
        return $dataProvider;
    }

    /**
     * 
     * @param int $data
     * @return \yii\data\ActiveDataProvider
     */
    public static function findMyLogiss($data = array()) {
        if (!isset($data['limit'])) {
            $data['limit'] = 10;
        }

        $query = Logistics::find()->Where('publis_user_id=:user_id', [':user_id' => $data['user_id']])->orderBy(" fee_lock asc,id desc ");
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $data['limit']]);
        $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        return ['models' => $models, 'pages' => $pages];
    }

    /**
     * 
     * @param int $data
     * @return \yii\data\ActiveDataProvider
     */
    public static function findMyBooks($data = array()) {
        if (!isset($data['limit'])) {
            $data['limit'] = 10;
        }

        $query = Logistics::find()->Where('fit_user_id=:user_id', [':user_id' => $data['user_id']])->orderBy(" fee_lock asc,id desc ");
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $data['limit']]);
        $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        return ['models' => $models, 'pages' => $pages];
    }

    /**
     * 
     * @param int $data
     * @return \yii\data\ActiveDataProvider
     */
    public static function findMyGifts($data = array()) {
        if (!isset($data['limit'])) {
            $data['limit'] = 10;
        }

        $query = Logistics::find()->Where('to_user_id=:user_id', [':user_id' => $data['user_id']])->orderBy(" fee_lock asc,id desc ");
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $data['limit']]);
        $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        return ['models' => $models, 'pages' => $pages];
    }

    public static function findIndexLists($limit) {
        return Product::find()->limit($limit)->orderBy(" product_id desc ")->all();
    }

}
