<?php

namespace common\models\tableviews;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "web_view_gifts".
 *
 * @property string $ac_cname
 * @property integer $ac_type
 * @property integer $ac_starttime
 * @property integer $ac_endtime
 * @property integer $user_id
 * @property string $id
 * @property integer $activity_id
 * @property string $gift_name
 * @property string $gift_price
 * @property integer $addtime
 * @property integer $updatetime
 * @property integer $fittime
 * @property string $addip
 * @property integer $gift_status
 */
class ViewGifts extends \yii\db\ActiveRecord {

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
            if ($string == 1) {
                return '未领取';
            } else {
                return '<span id="fit_gift_'.$this->id.'" class="btn btn-sm btn-danger showModalButton pull-right" value="/member/account/getgift/'.$this->id.'/'.$this->ac_type.'.html" title="信息提示">领取</span>';
            }
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'web_view_gifts';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ac_type', 'ac_starttime', 'ac_endtime', 'user_id', 'id', 'activity_id', 'addtime', 'updatetime', 'fittime', 'gift_status'], 'integer'],
            [['gift_name'], 'required'],
            [['gift_price'], 'number'],
            [['ac_cname', 'gift_name'], 'string', 'max' => 255],
            [['addip'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ac_cname' => 'Ac Cname',
            'ac_type' => 'Ac Type',
            'ac_starttime' => 'Ac Starttime',
            'ac_endtime' => 'Ac Endtime',
            'user_id' => 'User ID',
            'id' => 'ID',
            'activity_id' => 'Activity ID',
            'gift_name' => 'Gift Name',
            'gift_price' => 'Gift Price',
            'addtime' => 'Addtime',
            'updatetime' => 'Updatetime',
            'fittime' => 'Fittime',
            'addip' => 'Addip',
            'gift_status' => 'Gift Status',
        ];
    }

}
