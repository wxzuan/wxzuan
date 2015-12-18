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
class Gift extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_gift';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'activity_id' => 'Activity ID',
            'gift_name' => 'Gift Name',
            'gift_price' => 'Gift Price',
            'gift_status' => 'Gift Status',
            'addtime' => 'Addtime',
            'updatetime' => 'Updatetime',
            'fittime' => 'Fittime',
            'addip' => 'Addip',
        ];
    }
}
