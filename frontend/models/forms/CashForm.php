<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class CashForm extends Model {

    public $money;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['money', 'filter', 'filter' => 'trim'],
            ['money', 'required', 'message' => '{attribute}不能空'],
            ['money', 'match', 'pattern' => '/^[0-9]{1,6}(.[0-9]{1,2})?$/', 'message' => '{attribute}请输入整的金额,最多不超过100W'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'money' => '提现金额'
        ];
    }

}
