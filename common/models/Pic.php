<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_pic".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $pic_type
 * @property string $pic_s_img
 * @property string $pic_m_img
 * @property string $pic_b_img
 * @property integer $pic_addtime
 * @property string $pic_addip
 */
class Pic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_pic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'pic_type', 'pic_addtime'], 'integer'],
            [['pic_s_img', 'pic_m_img', 'pic_b_img'], 'string', 'max' => 255],
            [['pic_addip'], 'string', 'max' => 45]
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
            'pic_type' => 'Pic Type',
            'pic_s_img' => 'Pic S Img',
            'pic_m_img' => 'Pic M Img',
            'pic_b_img' => 'Pic B Img',
            'pic_addtime' => 'Pic Addtime',
            'pic_addip' => 'Pic Addip',
        ];
    }
}
