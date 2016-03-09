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
    public static function findProducts($data = array(),$userArea=FALSE) {
        //如果设置只显示用户所在的区域，那么只显示这个用户所在的的城市信息
        
        
        if (!isset($data['limit'])) {
            $data['limit'] = 10;
        }
        $model = new Product();
        if($userArea==TRUE){
            $userinfo=\Yii::$app->user->identity;
            $query=$model->find()->Where('product_status=:status AND product_province=:province AND product_city=:city', [':status' => 0,':province'=>$userinfo->province,':city'=>$userinfo->city])->orderBy(" product_id desc ")->limit($data['limit']);
        }else{
           $query=$model->find()->Where('product_status=:status', [':status' => 0])->orderBy(" product_id desc ")->limit($data['limit']); 
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
