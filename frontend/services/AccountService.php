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

use common\models\AccountLog;
use common\models\Cash;
use yii\data\Pagination;
use common\models\tableviews\ViewGifts;

class AccountService {

    /**
     * 
     * @param int $data
     * @return \yii\data\ActiveDataProvider
     */
    public static function findAccountlog($data = array()) {
        if (!isset($data['limit'])) {
            $data['limit'] = 10;
        }
        $query = AccountLog::find()->Where('user_id=:user_id', [':user_id' => $data['user_id']])->orderBy(" addtime desc ");
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
    public static function findCashlog($data = array()) {
        if (!isset($data['limit'])) {
            $data['limit'] = 10;
        }
        $query = Cash::find()->Where('user_id=:user_id', [':user_id' => $data['user_id']])->orderBy(" addtime desc ");
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
     * @return type
     */
    public static function findGift($data = array()) {
        if (!isset($data['limit'])) {
            $data['limit'] = 10;
        }
        $type=1;
        if(isset($data['get']['type'])){
            $type=  intval($data['get']['type']);
        }
        $query = ViewGifts::find()->Where('user_id=:user_id AND ac_type=:actype', [':user_id' => $data['user_id'],':actype'=>$type])->orderBy(" id desc ");
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => $data['limit']]);
        $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        return ['models' => $models, 'pages' => $pages];
    }

}
