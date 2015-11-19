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
use app\models\Product;
use yii\data\ActiveDataProvider;

class ProductService {

    //put your code here
    public static function findProducts($data = array()) {
        if (!isset($data['limit'])) {
            $data['limit'] = 10;
        }
        $model = new Product();
        $dataProvider = new ActiveDataProvider([
            'query' => $model->find()->Where('product_status=:status', [':status' => 0])->limit($data['limit']),
            'pagination' => [
                'pagesize' => $data['limit'],
            ]
        ]);
        return $dataProvider;
    }

}
