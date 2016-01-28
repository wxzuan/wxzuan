<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_cash".
 *
 * @property string $id
 * @property integer $user_id
 * @property string $realname
 * @property integer $status
 * @property string $package_id
 * @property string $submittocaifutong_time
 * @property string $return_result
 * @property string $account
 * @property integer $bank
 * @property string $bank_name
 * @property string $branch
 * @property integer $province
 * @property integer $city
 * @property string $total
 * @property string $credited
 * @property string $fee
 * @property integer $verify_userid
 * @property integer $verify_time
 * @property string $verify_remark
 * @property integer $examine_status
 * @property string $examine_remark
 * @property integer $addtime
 * @property string $addip
 * @property integer $acc_type
 * @property integer $coupon_id
 * @property integer $off_rate
 * @property integer $sms_status
 */
class Cash extends \yii\db\ActiveRecord {

    /**
     * 获得提现状态
     * return string
     */
    public function getStatusRemark() {
        $resturnString = '';
        switch ($this->status) {
            case 0:$resturnString = '待处理';
                break;
            case 1:$resturnString = '已成功';
                break;
            case 2:$resturnString = '已失败';
                break;
            case 2:$resturnString = '已提交';
                break;
            default :$resturnString = '待处理';
        }
        return $resturnString;
    }
    /**
     * 获得提现状态
     * return string
     */
    public function getfitStatus() {
        $resturnString = '';
        switch ($this->status) {
            case 0:$resturnString = '<span id="fit_cashcancel_' . $this->id . '" class="btn btn-danger btn-sm showModalButton pull-right" value="/member/account/cancelcash/' . $this->id . '.html" title="信息提示">取消提现</span>';
                break;
            case 1:$resturnString = '已成功';
                break;
            case 2:$resturnString = '已失败';
                break;
            case 4:$resturnString = '已取消';
                break;
            default :$resturnString = '待处理';
        }
        return $resturnString;
    }
    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'web_cash';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'status', 'submittocaifutong_time', 'bank', 'province', 'city', 'verify_userid', 'verify_time', 'examine_status', 'addtime', 'acc_type', 'coupon_id', 'off_rate', 'sms_status'], 'integer'],
            [['total'], 'required'],
            [['total', 'credited', 'fee'], 'number'],
            [['realname', 'package_id', 'branch'], 'string', 'max' => 100],
            [['return_result'], 'string', 'max' => 500],
            [['account'], 'string', 'max' => 50],
            [['bank_name', 'examine_remark'], 'string', 'max' => 255],
            [['verify_remark'], 'string', 'max' => 250],
            [['addip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'realname' => 'Realname',
            'status' => 'Status',
            'package_id' => 'Package ID',
            'submittocaifutong_time' => 'Submittocaifutong Time',
            'return_result' => 'Return Result',
            'account' => 'Account',
            'bank' => 'Bank',
            'bank_name' => 'Bank Name',
            'branch' => 'Branch',
            'province' => 'Province',
            'city' => 'City',
            'total' => 'Total',
            'credited' => 'Credited',
            'fee' => 'Fee',
            'verify_userid' => 'Verify Userid',
            'verify_time' => 'Verify Time',
            'verify_remark' => 'Verify Remark',
            'examine_status' => 'Examine Status',
            'examine_remark' => 'Examine Remark',
            'addtime' => 'Addtime',
            'addip' => 'Addip',
            'acc_type' => 'Acc Type',
            'coupon_id' => 'Coupon ID',
            'off_rate' => 'Off Rate',
            'sms_status' => 'Sms Status',
        ];
    }

}
