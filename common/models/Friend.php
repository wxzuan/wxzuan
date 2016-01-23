<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_friend".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $friend_id
 * @property integer $addtime
 * @property string $addip
 */
class Friend extends \yii\db\ActiveRecord {

    // 获取所属用户
    public function getUser() {
        //同样第一个参数指定关联的子表模型类名
        //
        return $this->hasOne(User::className(), ['user_id' => 'friend_id']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'web_friend';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'friend_id', 'addtime', 'addip'], 'required'],
            [['user_id', 'friend_id', 'addtime'], 'integer'],
            [['addip'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'Use ID',
            'friend_id' => 'Friend ID',
            'addtime' => 'Addtime',
            'addip' => 'Addip',
        ];
    }

}
