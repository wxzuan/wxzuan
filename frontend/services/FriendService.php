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

use common\models\Friend;
use yii\data\ActiveDataProvider;
use \Yii;

class FriendService {

    /**
     * 
     * @param int $data
     * @return \yii\data\ActiveDataProvider
     */
    public static function findFriends($data = array()) {
        if (!isset($data['limit'])) {
            $data['limit'] = 10;
        }
        $model = new Friend();
        $dataProvider = new ActiveDataProvider([
            'query' => $model->find()->Where('user_id=:user_id', [':user_id' => $data['user_id']])->orderBy(" id desc ")->limit($data['limit']),
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
    public static function findMyProducts($data = array()) {
        if (!isset($data['limit'])) {
            $data['limit'] = 10;
        }
        $model = new Product();
        $dataProvider = new ActiveDataProvider([
            'query' => $model->find()->Where('product_user_id=:user_id', [':user_id' => $data['user_id']])->orderBy(" product_id desc "),
            'pagination' => [
                'pagesize' => $data['limit'],
            ]
        ]);
        return $dataProvider;
    }
    public static function findIndexLists($limit){
        return Product::find()->limit($limit)->orderBy(" product_id desc ")->all();
    }

}
