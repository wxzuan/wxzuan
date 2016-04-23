<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_fixture".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $house_areas
 * @property integer $house_nums
 * @property string $house_willpay
 * @property integer $house_province
 * @property integer $house_city
 * @property integer $house_area
 * @property integer $house_repaynums
 * @property string $house_title
 * @property string $house_content
 * @property string $house_addtime
 */
class Fixture extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_fixture';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'house_title'], 'required'],
            [['user_id', 'house_nums', 'house_province', 'house_city', 'house_area', 'house_repaynums'], 'integer'],
            [['house_areas', 'house_willpay'], 'number'],
            [['house_addtime'], 'safe'],
            [['house_title'], 'string', 'max' => 255],
            [['house_content'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'user_id' => '用户ID',
            'house_areas' => '房间总大小',
            'house_nums' => '总房间数',
            'house_willpay' => '装修预算',
            'house_province' => '所在省份',
            'house_city' => '所有城市',
            'house_area' => '所在区域',
            'house_repaynums' => '回复数',
            'house_title' => '标题',
            'house_content' => '更多信息',
            'house_addtime' => '添加的时间',
        ];
    }
}
