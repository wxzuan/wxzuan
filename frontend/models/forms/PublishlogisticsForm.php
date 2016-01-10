<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Logistics;
use common\models\Friend;
use common\services\CacheService;
use common\models\User;
use common\models\Account;
use frontend\services\LogisticsService;

/**
 * ContactForm is the model behind the contact form.
 */
class PublishlogisticsForm extends Model {

    public $logis_name;
    public $logis_bail;
    public $logis_fee;
    public $to_user_id;
    public $logis_description;
    public $logis_arrivetime;
    public $publis_user_id;
    public $logis_country;
    public $logis_provice;
    public $logis_city;
    public $logis_area;
    public $logis_detailaddress;
    public $user_country;
    public $user_province;
    public $user_city;
    public $user_area;
    public $user_address;

    /**
     * 验证用户是否有足够资金发布项目
     */
    public function logisfeeRight() {
        $oneAccount = Account::find()->where("user_id=:user_id", [':user_id' => $this->publis_user_id])->one();
        if ($this->logis_fee > $oneAccount->use_money) {
            $this->addError('logis_fee', '您的可用资金不足以支付佣金。');
            return false;
        }
    }

    /**
     * 验证用户是否合法
     */
    public function UseridRight() {
        $friendUser = User::find()->where("user_id=:user_id", [':user_id' => $this->to_user_id])->one();
        if (!$friendUser->province || !$friendUser->city || !$friendUser->address) {
            $this->addError('logis_name', '请先通知好友完善个人地址信息。');
            return false;
        }
        $this->logis_country = '中国';
        $this->logis_provice = CacheService::getProvinceNameById($friendUser->province);
        $this->logis_city = CacheService::getCityNameById($friendUser->city);
        if ($friendUser->area) {
            $this->logis_area = CacheService::getAreaNameById($friendUser->area);
        } else {
            $this->logis_area = '无';
        }
        $this->logis_detailaddress = $friendUser->address;
        //配置发布用户的地址信息
        $publishUser = User::find()->where("user_id=:user_id", [':user_id' => $this->publis_user_id])->one();
        if (!$publishUser->province || !$publishUser->city || !$publishUser->address) {
            $this->addError('logis_name', '您的个人地址信息不完整。');
            return false;
        }
        $this->user_country = '中国';
        $this->user_province = CacheService::getProvinceNameById($publishUser->province);
        $this->user_city = CacheService::getCityNameById($publishUser->city);
        if ($publishUser->area) {
            $this->user_area = CacheService::getAreaNameById($publishUser->area);
        } else {
            $this->user_area = '无';
        }
        $this->user_address = $publishUser->address;
    }

    function __construct($config = array()) {
        parent::__construct($config);
        $this->publis_user_id = Yii::$app->user->getId();
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['logis_name', 'logis_bail', 'logis_fee', 'to_user_id', 'logis_description', 'logis_arrivetime'], 'filter', 'filter' => 'trim'],
            [['logis_name', 'logis_bail', 'logis_fee', 'to_user_id', 'logis_description', 'logis_arrivetime'], 'required', 'message' => '{attribute}不能空'],
            ['logis_name', 'string', 'min' => 2, 'max' => 100, 'message' => '{attribute}在2至100个字符之间'],
            ['to_user_id', 'UseridRight'],
            ['logis_fee', 'logisfeeRight'],
            [['logis_bail', 'logis_fee'], 'match', 'pattern' => '/^(([1-9]\d{0,9})|0)(\.\d{1,2})?$/', 'message' => '请输入有效的金额'],
            [['logis_bail', 'logis_fee'], 'string', 'min' => 1, 'max' => 10, 'message' => '{attribute}在1至10个字符之间'],
            ['logis_description', 'string', 'max' => 60000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'logis_name' => '物品名称',
            'logis_bail' => '物品保证金',
            'logis_fee' => '佣金',
            'to_user_id' => '收货用户',
            'logis_description' => '货物简介',
            'logis_arrivetime' => '最迟到达时间'
        ];
    }

    /**
     * 获得活动分类
     * @return type
     */
    public function showUsername() {
        $fitArray = [];
        $result = Friend::find()->where('user_id=:user_id', [':user_id' => $this->publis_user_id])->indexBy('id')->all();
        if ($result) {
            foreach ($result as $key => $value) {
                $fitArray[$value->friend_id] = $value->user->username;
            }
        }
        return $fitArray;
    }

    /**
     * 保存商品
     */
    public function save() {
        $newLogis = new Logistics();
        $newLogis->setAttributes($this->attributes);
        $newLogis->setAttribute('user_country', $this->user_country);
        $newLogis->setAttribute('user_province', $this->user_province);
        $newLogis->setAttribute('user_city',$this->user_city);
        $newLogis->setAttribute('user_area', $this->user_area);
        $newLogis->setAttribute('user_address', $this->user_address);
        $newLogis->setAttribute('fit_user_id', 0);
        $newLogis->setAttribute('bail_lock', 0);
        $newLogis->setAttribute('fee_lock', 0);
        $newLogis->setAttribute('logis_arrivetime', strtotime($this->logis_arrivetime));
        $newLogis->setAttribute('logis_realarrivetime', 0);
        $newLogis->setAttribute("logis_addtime", time());
        $newLogis->setAttribute('logis_addip', \Yii::$app->request->userIp);
        if ($newLogis->save()) {
            $logisct_id = \Yii::$app->db->lastInsertID;
            $result = LogisticsService::lockLogisticsFee($this->publis_user_id, $logisct_id);
            if ($result['status'] == 1) {
                return true;
            } else {
                $this->addError('logis_name', $result['remark']);
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

}
