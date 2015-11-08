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
use common\models\ProductOrder;

class OrderService {

    //put your code here
    public static function findProductOrder($data = array()) {
        if (!isset($data['limit'])) {
            $data['limit'] = 10;
        }
        $productorders = ProductOrder::find()
                ->Where('user_id=:user_id', [':user_id' => $data['user_id']])
                ->limit($data['limit'])
                ->all();
        return $productorders;
    }

}
