<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class SearchProcessForm extends Model {

    public $orderno;
    public $ordercompany_type;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['orderno', 'ordercompany_type'], 'filter', 'filter' => 'trim'],
            [['orderno', 'ordercompany_type'], 'required', 'message' => '{attribute}不能空']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'orderno' => '快递订单号',
            'ordercompany_type' => '快递公司'
        ];
    }

}
