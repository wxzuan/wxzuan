<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_account_log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $type
 * @property string $money
 * @property string $total
 * @property string $use_money
 * @property string $no_use_money
 * @property string $collection
 * @property integer $to_user
 * @property string $remark
 * @property integer $addtime
 * @property string $addip
 * @property integer $checkid
 * @property integer $moneyactiontype
 */
class AccountLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_account_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'to_user'], 'required'],
            [['user_id', 'to_user', 'addtime', 'checkid', 'moneyactiontype'], 'integer'],
            [['money', 'total', 'use_money', 'no_use_money', 'collection'], 'number'],
            [['type'], 'string', 'max' => 100],
            [['remark', 'addip'], 'string', 'max' => 255]
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
            'type' => 'Type',
            'money' => 'Money',
            'total' => 'Total',
            'use_money' => 'Use Money',
            'no_use_money' => 'No Use Money',
            'collection' => 'Collection',
            'to_user' => 'To User',
            'remark' => 'Remark',
            'addtime' => 'Addtime',
            'addip' => 'Addip',
            'checkid' => 'Checkid',
            'moneyactiontype' => 'Moneyactiontype',
        ];
    }
    /**
     * 资金类型处理
     * 所有类型暂时未分完
     * @return string
     */
    function getTypeRemark(){
        if($this->moneyactiontype==21322){
            return '<span style="color:blue">冻结</span>';
        }else{
            return '<span style="color:green">冻结</span>';
        }
    }
}
