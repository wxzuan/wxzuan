<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_activity_remind".
 *
 * @property string $id
 * @property integer $activity_id
 * @property integer $user_id
 * @property string $remind_name
 * @property integer $remind_type
 * @property string $remind_mark
 * @property integer $addtime
 */
class ActivityRemind extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_activity_remind';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activity_id', 'user_id'], 'required'],
            [['activity_id', 'user_id', 'remind_type', 'addtime'], 'integer'],
            [['remind_name'], 'string', 'max' => 100],
            [['remind_mark'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activity_id' => 'Activity ID',
            'user_id' => 'User ID',
            'remind_name' => 'Remind Name',
            'remind_type' => 'Remind Type',
            'remind_mark' => 'Remind Mark',
            'addtime' => 'Addtime',
        ];
    }
}
