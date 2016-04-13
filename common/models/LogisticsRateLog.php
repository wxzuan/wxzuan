<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_logistics_rate_log".
 *
 * @property integer $id
 * @property integer $logist_id
 * @property integer $user_id
 * @property string $rate
 * @property string $addtime
 */
class LogisticsRateLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_logistics_rate_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['logist_id', 'user_id'], 'required'],
            [['logist_id', 'user_id'], 'integer'],
            [['addtime'], 'safe'],
            [['rate'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'logist_id' => '物流ID',
            'user_id' => '用户ID',
            'rate' => '进度',
            'addtime' => '添加时间',
        ];
    }
}
