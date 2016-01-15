<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_logistics".
 *
 * @property integer $id
 * @property integer $publis_user_id
 * @property string $user_country
 * @property string $user_province
 * @property string $user_city
 * @property string $user_area
 * @property string $user_address
 * @property integer $to_user_id
 * @property string $hash_key
 * @property string $logis_country
 * @property string $logis_provice
 * @property string $logis_city
 * @property string $logis_area
 * @property string $logis_detailaddress
 * @property integer $fit_user_id
 * @property string $logis_name
 * @property string $logis_s_img
 * @property string $logis_m_img
 * @property string $logis_b_img
 * @property string $logis_bail
 * @property integer $bail_lock
 * @property string $logis_fee
 * @property integer $fee_lock
 * @property string $logis_description
 * @property integer $logis_arrivetime
 * @property integer $logis_realarrivetime
 * @property integer $logis_addtime
 * @property string $logis_addip
 */
class Logistics extends \yii\db\ActiveRecord {

    /**
     * 获得物品处理状态
     * @return string
     */
    public function showFitButton() {
        $returnString = "";
        switch ($this->fee_lock) {
            case 0 :

                $returnString.='<span id="fit_gift_' . $this->id . '" class="btn btn-sm btn-danger showModalButton pull-right" value="/member/logistics/index/del/' . $this->id . '.html" title="信息提示">删除</span>';
                break;
            case 1:
                if ($this->bail_lock == 0) {
                    $returnString.='<span id="fit_gift_' . $this->id . '" class="btn btn-sm btn-danger showModalButton pull-right" value="/member/logistics/index/outcode/' . $this->id . '.html" title="信息提示">出货</span>';
                } else {
                    $returnString.='<span id="fit_gift_' . $this->id . '" class="btn btn-sm btn-danger showModalButton pull-right" value="/member/logistics/fitlogis/' . $this->id . '.html" title="信息提示">撤消</span>';
                }
                break;
            default :
        }
        return $returnString;
    }

    // 获取所属用户
    public function getUser() {
        //同样第一个参数指定关联的子表模型类名
        //
        return $this->hasOne(User::className(), ['user_id' => 'publis_user_id']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'web_logistics';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['publis_user_id', 'to_user_id', 'fit_user_id', 'bail_lock', 'fee_lock', 'logis_arrivetime', 'logis_realarrivetime', 'logis_addtime'], 'integer'],
            [['user_country', 'user_province', 'user_city', 'user_area', 'user_address', 'logis_country', 'logis_provice', 'logis_city', 'logis_area', 'logis_detailaddress', 'logis_name', 'logis_description', 'logis_addip'], 'required'],
            [['logis_bail', 'logis_fee'], 'number'],
            [['logis_description'], 'string'],
            [['user_country', 'user_province', 'user_city', 'user_area', 'user_address', 'logis_country', 'logis_provice', 'logis_city', 'logis_area', 'logis_detailaddress', 'logis_name'], 'string', 'max' => 200],
            [['hash_key'], 'string', 'max' => 255],
            [['logis_s_img', 'logis_m_img', 'logis_b_img'], 'string', 'max' => 300],
            [['logis_addip'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'publis_user_id' => 'Publis User ID',
            'user_country' => 'User Country',
            'user_province' => 'User Province',
            'user_city' => 'User City',
            'user_area' => 'User Area',
            'user_address' => 'User Address',
            'to_user_id' => 'To User ID',
            'hash_key' => 'Hash Key',
            'logis_country' => 'Logis Country',
            'logis_provice' => 'Logis Provice',
            'logis_city' => 'Logis City',
            'logis_area' => 'Logis Area',
            'logis_detailaddress' => 'Logis Detailaddress',
            'fit_user_id' => 'Fit User ID',
            'logis_name' => 'Logis Name',
            'logis_s_img' => 'Logis S Img',
            'logis_m_img' => 'Logis M Img',
            'logis_b_img' => 'Logis B Img',
            'logis_bail' => 'Logis Bail',
            'bail_lock' => 'Bail Lock',
            'logis_fee' => 'Logis Fee',
            'fee_lock' => 'Fee Lock',
            'logis_description' => 'Logis Description',
            'logis_arrivetime' => 'Logis Arrivetime',
            'logis_realarrivetime' => 'Logis Realarrivetime',
            'logis_addtime' => 'Logis Addtime',
            'logis_addip' => 'Logis Addip',
        ];
    }

}
