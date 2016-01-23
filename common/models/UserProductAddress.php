<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_user_proudct_address".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $realname
 * @property string $phone
 * @property string $address
 * @property string $sysaddress
 * @property integer $province
 * @property integer $city
 * @property integer $area
 * @property integer $addtime
 * @property string $addip
 */
class UserProductAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_user_proudct_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'realname', 'phone', 'address', 'sysaddress', 'province', 'city', 'area', 'addtime', 'addip'], 'required'],
            [['user_id', 'province', 'city', 'area', 'addtime'], 'integer'],
            [['realname', 'addip'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 35],
            [['address', 'sysaddress'], 'string', 'max' => 500],
            [['user_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'realname' => 'Realname',
            'phone' => 'Phone',
            'address' => 'Address',
            'sysaddress' => 'Sysaddress',
            'province' => 'Province',
            'city' => 'City',
            'area' => 'Area',
            'addtime' => 'Addtime',
            'addip' => 'Addip',
        ];
    }
}
