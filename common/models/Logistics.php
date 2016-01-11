<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_logistics".
 *
 * @property integer $id
 * @property integer $publis_user_id
 * @property integer $to_user_id
 * @property string $logis_country
 * @property string $logis_provice
 * @property string $logis_city
 * @property string $logis_area
 * @property string $logis_detailaddress
 * @property integer $fit_user_id
 * @property string $logis_name
 * @property string $logis_bail
 * @property string $logis_fee
 * @property string $logis_description
 * @property integer $logis_arrivetime
 * @property integer $logis_realarrivetime
 * @property integer $logis_addtime
 * @property string $logis_addip
 */
class Logistics extends \yii\db\ActiveRecord {

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
            [['publis_user_id', 'to_user_id', 'fit_user_id', 'logis_arrivetime', 'logis_realarrivetime', 'logis_addtime'], 'integer'],
            [['logis_country', 'logis_provice', 'logis_city', 'logis_area', 'logis_detailaddress', 'logis_name', 'logis_description', 'logis_addip'], 'required'],
            [['logis_bail', 'logis_fee'], 'number'],
            [['logis_description'], 'string'],
            [['logis_country', 'logis_provice', 'logis_city', 'logis_area', 'logis_detailaddress', 'logis_name'], 'string', 'max' => 200],
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
            'to_user_id' => 'To User ID',
            'logis_country' => 'Logis Country',
            'logis_provice' => 'Logis Provice',
            'logis_city' => 'Logis City',
            'logis_area' => 'Logis Area',
            'logis_detailaddress' => 'Logis Detailaddress',
            'fit_user_id' => 'Fit User ID',
            'logis_name' => 'Logis Name',
            'logis_bail' => 'Logis Bail',
            'logis_fee' => 'Logis Fee',
            'logis_description' => 'Logis Description',
            'logis_arrivetime' => 'Logis Arrivetime',
            'logis_realarrivetime' => 'Logis Realarrivetime',
            'logis_addtime' => 'Logis Addtime',
            'logis_addip' => 'Logis Addip',
        ];
    }

}
