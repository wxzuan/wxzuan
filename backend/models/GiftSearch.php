<?php

namespace backend\models;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GiftSearch
 *
 * @author Administrator
 */
class GiftSearch extends \common\models\Gift {

    //put your code here
    public function search($params) {
        $query = GiftSearch::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        return $dataProvider;
    }

}

?>
