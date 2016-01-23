<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class UserProductAddressForm extends Model {

    public $phone;
    public $address;
    public $realname;
    public $user_id;

    function __construct($config = array()) {
        parent::__construct($config);
        $this->user_id = Yii::$app->user->getId();
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['realname', 'phone', 'address'], 'filter', 'filter' => 'trim'],
            [['realname', 'phone', 'address'], 'required', 'message' => '{attribute}不能空'],
            ['realname', 'string', 'min' => 2, 'max' => 100, 'message' => '{attribute}在2至100个字符之间'],
            ['address', 'string', 'min' => 5, 'max' => 50, 'message' => '{attribute}在20至50个字符之间'],
            ['phone', 'match', 'pattern' => '/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|18[0-9]{9}$/', 'message' => '请输入正确的手机号码']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'phone' => '手机号码',
            'address' => '收货地址',
            'realname' => '真实姓名'
        ];
    }

}
