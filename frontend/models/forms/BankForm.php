<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class BankForm extends Model {

    public $bank;
    public $bank_type;
    public $realname;
    public $account;
    public $branch;
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
            [['bank', 'bank_type', 'realname', 'account', 'branch'], 'filter', 'filter' => 'trim'],
            [['realname', 'account', 'branch'], 'required', 'message' => '{attribute}不能空'],
            ['realname', 'string', 'min' => 2, 'max' => 100, 'message' => '{attribute}在2至100个字符之间'],
            ['account', 'string', 'min' => 8, 'max' => 50, 'message' => '{attribute}在20至50个字符之间'],
            ['branch', 'string', 'min' => 4, 'max' => 100, 'message' => '{attribute}在4至100个字符之间']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'bank' => '所属银行',
            'bank_type' => '银行类型',
            'realname' => '真实姓名',
            'account' => '银行帐号',
            'branch' => '支行名称'
        ];
    }

}
