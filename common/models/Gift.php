<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_gift".
 *
 * @property string $id
 * @property integer $user_id
 * @property integer $activity_id
 * @property string $gift_name
 * @property string $gift_price
 * @property integer $gift_status
 * @property integer $addtime
 * @property integer $updatetime
 * @property integer $fittime
 * @property string $addip
 */
class Gift extends \yii\db\ActiveRecord {

    public function showUsername() {
        if ($this->user_id == 0) {
            return '无';
        } else {
            return '<span title=' . $this->user->username . '>' . substr($this->user->username, 0, 10) . '...' . '</span>';
        }
    }

    /**
     * 处理显示的时候
     * @param type $time
     * @return string
     */
    public function showData($time) {
        if ($time) {
            return Date('Y-m-d/H:i:s', $time);
        } else {
            return '暂无数据';
        }
    }

    /**
     * 显示抽取状态
     * @return string
     */
    public function showGiftStaus() {
        if ($this->gift_status == 1) {
            return '已抽中';
        } else {
            return '待抽取';
        }
    }

    /**
     * 显示领取状态
     * @return string
     */
    public function showFittimeRemark($string = 0) {
        if ($this->fittime) {
            if ($string == 1) {
                return date('Y年m月d日H时i分s秒', $this->fittime);
            } else {
                return '已领取';
            }
        } else {
            return '未领取';
        }
    }

// 获取所属活动
    public function getActivity() {
        //同样第一个参数指定关联的子表模型类名
        //
        return $this->hasOne(Activity::className(), ['id' => 'activity_id']);
    }

// 获取所属用户
    public function getUser() {
        //同样第一个参数指定关联的子表模型类名
        //
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'web_gift';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'activity_id', 'gift_status', 'addtime', 'updatetime', 'fittime'], 'integer'],
            [['gift_name'], 'required'],
            [['gift_price'], 'number'],
            [['gift_name'], 'string', 'max' => 255],
            [['addip'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => '中奖用户',
            'activity_id' => '活动类型',
            'gift_name' => '物品名称',
            'gift_price' => '物品价值',
            'gift_status' => '是否中奖',
            'addtime' => '添加时间',
            'updatetime' => '更新时间',
            'fittime' => '领取时间',
            'addip' => '添加IP',
        ];
    }

}
