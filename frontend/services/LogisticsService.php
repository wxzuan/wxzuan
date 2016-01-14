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

class LogisticsService {

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

    public static function findIndexLists($limit) {
        return Product::find()->limit($limit)->orderBy(" product_id desc ")->all();
    }

}
