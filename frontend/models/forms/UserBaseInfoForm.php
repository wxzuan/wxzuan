<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * ContactForm is the model behind the contact form.
 */
class UserBaseInfoForm extends Model {

    public $realname;
    public $card_id;
    public $phone;
    public $email;
    public $phone_status;
    public $email_status;
    public $real_status;
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
            [['realname', 'card_id', 'phone', 'email'], 'filter', 'filter' => 'trim'],
            [['realname', 'card_id', 'phone'], 'required', 'message' => '{attribute}不能空'],
            ['realname', 'string', 'min' => 2, 'max' => 100, 'message' => '{attribute}在2至100个字符之间'],
            ['card_id', 'cardRight'],
            ['phone', 'match', 'pattern' => '/^13[0-9]{1}[0-9]{8}$|15[0189]{1}[0-9]{8}$|189[0-9]{8}$/', 'message' => '请输入正确的手机号码'],
            ['email', 'email', 'message' => '请输入有效的邮箱'],
            ['card_id', 'oneCardId'],
            ['phone', 'onePhone'],
            ['email', 'oneEmail'],
            [['real_status', 'phone_status', 'email_status'], 'in', 'range' => [0, 1]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'realname' => '真实姓名',
            'card_id' => '证件号码',
            'phone' => '手机号码',
            'email' => '电子邮箱',
            'phone_status' => '手机状态',
            'email_status' => '邮箱状态',
            'real_status' => '实名状态'
        ];
    }

    /**
     * 验证身份证的合法性Ï
     */
    public function cardRight() {
        if (!$this->validation_filter_id_card($this->card_id)) {
            $this->addError('card_id', '输入的身份证不合法');
        }
    }

    public function validation_filter_id_card($id_card) {
        if (strlen($id_card) == 18) {
            return $this->idcard_checksum18($id_card);
        } elseif ((strlen($id_card) == 15)) {
            $id_card = idcard_15to18($id_card);
            return $this->idcard_checksum18($id_card);
        } else {
            return false;
        }
    }

    // 计算身份证校验码，根据国家标准GB 11643-1999
    public function idcard_verify_number($idcard_base) {
        if (strlen($idcard_base) != 17) {
            return false;
        }
        //加权因子
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        //校验码对应值
        $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
        $checksum = 0;
        for ($i = 0; $i < strlen($idcard_base); $i++) {
            $checksum += substr($idcard_base, $i, 1) * $factor[$i];
        }
        $mod = $checksum % 11;
        $verify_number = $verify_number_list[$mod];
        return $verify_number;
    }

    // 将15位身份证升级到18位
    public function idcard_15to18($idcard) {
        if (strlen($idcard) != 15) {
            return false;
        } else {
            // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
            if (array_search(substr($idcard, 12, 3), array('996', '997', '998', '999')) !== false) {
                $idcard = substr($idcard, 0, 6) . '18' . substr($idcard, 6, 9);
            } else {
                $idcard = substr($idcard, 0, 6) . '19' . substr($idcard, 6, 9);
            }
        }
        $idcard = $idcard . $this->idcard_verify_number($idcard);
        return $idcard;
    }

    // 18位身份证校验码有效性检查
    public function idcard_checksum18($idcard) {
        if (strlen($idcard) != 18) {
            return false;
        }
        $idcard_base = substr($idcard, 0, 17);
        if ($this->idcard_verify_number($idcard_base) != strtoupper(substr($idcard, 17, 1))) {
            return false;
        } else {
            return true;
        }
    }

    function oneCardId() {
        $countone = User::find()->where("card_id=:card_id AND user_id!=:user_id", [':card_id' => $this->card_id, ':user_id' => $this->user_id])->count();
        if ($countone > 0) {
            $this->addError('card_id', '身份证已经被占用');
        }
    }

    function oneEmail() {
        $countone = User::find()->where("email=:email AND email_status=1 AND user_id!=:user_id", [':email' => $this->email, ':user_id' => $this->user_id])->count();
        if ($countone > 0) {
            return false;
        }
    }

    public function onePhone() {
        $countone = User::find()->where("phone=:phone AND phone_status=1 AND user_id!=:user_id", [':phone' => $this->phone, ':user_id' => $this->user_id])->count();
        if ($countone > 0) {
            $this->addError('phone', '手机号码已经被占用');
        }
    }

}
