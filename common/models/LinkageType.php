<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_linkage_type".
 *
 * @property integer $id
 * @property string $ename
 * @property string $cname
 */
class LinkageType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_linkage_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ename', 'cname'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ename' => 'Ename',
            'cname' => 'Cname',
        ];
    }
}
