<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_province".
 *
 * @property integer $id
 * @property string $provinceID
 * @property string $province
 */
class Province extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_province';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provinceID'], 'string', 'max' => 6],
            [['province'], 'string', 'max' => 40]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'provinceID' => 'Province ID',
            'province' => 'Province',
        ];
    }
}
