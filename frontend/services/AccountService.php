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
use yii\data\ActiveDataProvider;

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
        $model = new AccountLog();
        $dataProvider = new ActiveDataProvider([
            'query' => $model->find()->Where('user_id=:user_id', [':user_id' => $data['user_id']]),
            'pagination' => [
                'pagesize' => $data['limit'],
            ]
        ]);
        return $dataProvider;
    }

}
