<?php

namespace backend\models\forms;

use yii\base\Model;
use common\models\Activity;
use common\models\Gift;

/**
 * UploadForm is the model behind the upload form.
 */
class PublishGiftForm extends Model {

    /**
     * @var UploadedFile file attribute
     */
    public $activity_id;
    public $gift_name;
    public $gift_price;
    public $gift_nums;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['activity_id', 'gift_name', 'gift_price', 'gift_nums'], 'filter', 'filter' => 'trim'],
            [['activity_id', 'gift_name', 'gift_price', 'gift_nums'], 'required', 'message' => '{attribute}不能空'],
            ['gift_nums', 'number', 'integerOnly' => true, 'message' => '{attribute}需为整数'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'activity_id' => '活动ID',
            'gift_name' => '名称',
            'gift_price' => '单个物品价值',
            'gift_nums' => '发布数量',
        ];
    }

    /**
     * 获得活动分类
     * @return type
     */
    public function showActivity() {
        $fitArray = [];
        $result = Activity::find()->select(['id', 'ac_cname'])->where('ac_status=0 and UNIX_TIMESTAMP() BETWEEN ac_starttime AND ac_endtime ')->asArray()->indexBy('id')->all();
        if ($result) {
            foreach ($result as $key => $value) {
                $fitArray[$key] = $value['ac_cname'];
            }
        }
        return $fitArray;
    }

    /**
     * 基本的验证
     */
    public function baseValition() {
        $returnString = TRUE;
        if (!is_numeric($this->gift_price) || $this->gift_price < 0) {
            $this->addError('gift_price', '资金输入有误');
            $returnString = FALSE;
        }
        if ($this->gift_nums < 1) {
            $this->addError('gift_nums', '发布数量需为整数');
            $returnString = FALSE;
        }
        return $returnString;
    }

    /**
     * 发布资金活动
     * @return boolean
     */
    public function publish() {
        //生成随机数据
        $total = $this->gift_price; //红包总金额   
        $num = $this->gift_nums; // 分成10个红包，支持10人随机领取   
        $moneyArray = [];
        $time = time();
        $addip = \Yii::$app->request->userIP;
        for ($i = 0; $i < $num; $i++) {
            $money = $this->gift_price;
            $moneyArray[$i] = [0, $this->activity_id, $this->gift_name, $money, 0, $time, 0, 0, $addip];
        }
        \Yii::$app->db->createCommand()->batchInsert(Gift::tableName(), ['user_id', 'activity_id', 'gift_name', 'gift_price', 'gift_status', 'addtime', 'updatetime', 'fittime', 'addip'], $moneyArray)->execute();
        Activity::updateAll(['ac_status'=>1],'id='.$this->activity_id);
        return true;
    }

}
