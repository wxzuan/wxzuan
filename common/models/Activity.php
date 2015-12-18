<?php

namespace common\models;

use Yii;
use common\models\User;

/**
 * This is the model class for table "web_activity".
 *
 * @property string $id
 * @property string $ac_name
 * @property string $ac_cname
 * @property integer $ac_status
 * @property integer $ac_type
 * @property integer $ac_starttime
 * @property integer $ac_endtime
 * @property integer $ac_addtime
 */
class Activity extends \yii\db\ActiveRecord {

    /**
     * 
     * @param \common\models\User $weixinuser
     * @param type $activity_id
     * @param type $gift_type
     * @return int
     */
    public function toRollActivity(User $weixinuser, $activity_id) {
        #调用抽奖程序
        try {
            $addip = \Yii::$app->request->userIP;
            $in_p_user_id = $weixinuser->user_id;
            $conn = Yii::$app->db;
            $command = $conn->createCommand('call p_toRollGift(:in_p_user_id,:activity_id,:in_addip,@out_status,@out_remark)');
            $command->bindParam(":in_p_user_id", $in_p_user_id, PDO::PARAM_INT);
            $command->bindParam(":activity_id", $activity_id, PDO::PARAM_INT);
            $command->bindParam(":in_addip", $addip, PDO::PARAM_STR, 50);
            $command->execute();
            $fit = $conn->createCommand("select @out_status as status,@out_remark as remark")->queryOne();
        } catch (Exception $e) {
            $fit = ['remark' => '系统繁忙，暂时无法处理', 'status' => 0];
        }
        return $fit;
    }

    /**
     * 判断是否在正确的状态
     * @return boolean
     */
    public function isRightStatus() {
        switch ($this->ac_status) {
            case 1: return TRUE;
            case 0 :
            case 2:
            default :return FALSE;
        }
    }

    /**
     * 
     * @return type
     */
    public function isRightStatusRemark() {
        switch ($this->ac_status) {
            case 1: return $this->ac_cname . '正在进行中';
            case 0 :return $this->ac_cname . '未经过审核';
            case 2:return $this->ac_cname . '已经发送完毕，敬请期待下次活动';
            default :return $this->ac_cname . '错误';
        }
    }

    /**
     * 判断是否在对应的日期内
     * @return boolean
     */
    public function isInDate() {
        if ($this->ac_type == 0) {
            return TRUE;
        }
        if ($this->ac_starttime > time()) {
            return FALSE;
        }
        if ($this->ac_endtime < time()) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 
     * @return type
     */
    public function isInDateRemark() {
        if ($this->ac_status == 0) {
            return $this->ac_cname . '正在进行中';
        }
        if ($this->ac_starttime > time()) {
            return $this->ac_cname . '还没有开始';
        }
        if ($this->ac_endtime < time()) {
            return $this->ac_cname . '已经结束';
        }
        return $this->ac_cname . '正在进行中';
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'web_activity';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ac_name'], 'required'],
            [['ac_status', 'ac_type', 'ac_starttime', 'ac_endtime', 'ac_addtime'], 'integer'],
            [['ac_name', 'ac_cname'], 'string', 'max' => 255],
            [['ac_name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ac_name' => 'Ac Name',
            'ac_cname' => 'Ac Cname',
            'ac_status' => 'Ac Status',
            'ac_type' => 'Ac Type',
            'ac_starttime' => 'Ac Starttime',
            'ac_endtime' => 'Ac Endtime',
            'ac_addtime' => 'Ac Addtime',
        ];
    }

}
