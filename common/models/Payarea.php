<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_payarea".
 *
 * @property integer $id
 * @property string $name
 * @property integer $p_code
 * @property integer $a_code
 * @property string $nid
 * @property integer $pid
 * @property string $domain
 * @property integer $order
 */
class Payarea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_payarea';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'p_code', 'a_code', 'nid', 'pid', 'domain', 'order'], 'required'],
            [['p_code', 'a_code', 'pid', 'order'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['nid'], 'string', 'max' => 200],
            [['domain'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'p_code' => 'P Code',
            'a_code' => 'A Code',
            'nid' => 'Nid',
            'pid' => 'Pid',
            'domain' => 'Domain',
            'order' => 'Order',
        ];
    }
}
