<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_city".
 *
 * @property integer $id
 * @property string $cityID
 * @property string $city
 * @property string $father
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_city';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cityID', 'father'], 'string', 'max' => 6],
            [['city'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cityID' => 'City ID',
            'city' => 'City',
            'father' => 'Father',
        ];
    }
}
