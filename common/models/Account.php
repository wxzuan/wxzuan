<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_account".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $total
 * @property string $use_money
 * @property string $no_use_money
 * @property string $collection
 * @property string $newworth
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['total', 'use_money', 'no_use_money', 'collection', 'newworth'], 'number'],
            [['user_id'], 'unique']
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
            'total' => 'Total',
            'use_money' => 'Use Money',
            'no_use_money' => 'No Use Money',
            'collection' => 'Collection',
            'newworth' => 'Newworth',
        ];
    }
}
