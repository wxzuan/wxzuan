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

use common\models\Product;
use yii\data\ActiveDataProvider;
use \Yii;

class ProductService {

    /**
     * 
     * @param int $data
     * @return \yii\data\ActiveDataProvider
     */
    public static function findProducts($data = array()) {
        if (!isset($data['limit'])) {
            $data['limit'] = 10;
        }
        $model = new Product();
        $dataProvider = new ActiveDataProvider([
            'query' => $model->find()->Where('product_status=:status', [':status' => 0])->orderBy(" product_id desc ")->limit($data['limit']),
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
