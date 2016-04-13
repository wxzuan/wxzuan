<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_comment".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $to_user_id
 * @property integer $top_id
 * @property string $c_type
 * @property integer $is_public
 * @property integer $c_nums
 * @property string $c_title
 * @property string $c_content
 * @property string $c_addtime
 */
class Comment extends \yii\db\ActiveRecord {

    // 获取所属用户
    public function getUser() {
        //同样第一个参数指定关联的子表模型类名
        //
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'web_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'c_title'], 'required'],
            [['user_id', 'to_user_id', 'top_id', 'is_public', 'c_nums'], 'integer'],
            [['c_type'], 'string'],
            [['c_addtime'], 'safe'],
            [['c_title'], 'string', 'max' => 255],
            [['c_content'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => '自增ID',
            'user_id' => '用户ID',
            'to_user_id' => '给谁的吐槽',
            'top_id' => '上一级对应的ID',
            'c_type' => '评论类型',
            'is_public' => '是否公开',
            'c_nums' => '回复数',
            'c_title' => '评论标题',
            'c_content' => '评论内容',
            'c_addtime' => '添加的时间',
        ];
    }

}
