<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_area".
 *
 * @property integer $id
 * @property string $areaID
 * @property string $area
 * @property string $father
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['areaID'], 'string', 'max' => 50],
            [['area'], 'string', 'max' => 60],
            [['father'], 'string', 'max' => 6]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'areaID' => 'Area ID',
            'area' => 'Area',
            'father' => 'Father',
        ];
    }
}
