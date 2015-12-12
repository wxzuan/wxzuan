<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_product_coupon".
 *
 * @property integer $id
 * @property integer $cash_id
 * @property integer $user_id
 * @property integer $obtain_time
 * @property integer $used_time
 * @property integer $off_rate
 * @property integer $status
 * @property string $type
 * @property integer $addtime
 */
class ProductCoupon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_product_coupon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cash_id', 'user_id', 'obtain_time', 'used_time', 'off_rate', 'status', 'addtime'], 'integer'],
            [['user_id'], 'required'],
            [['type'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cash_id' => 'Cash ID',
            'user_id' => 'User ID',
            'obtain_time' => 'Obtain Time',
            'used_time' => 'Used Time',
            'off_rate' => 'Off Rate',
            'status' => 'Status',
            'type' => 'Type',
            'addtime' => 'Addtime',
        ];
    }
}
