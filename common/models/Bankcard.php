<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_bankcard".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $realname
 * @property string $account
 * @property string $bank
 * @property integer $bank_type
 * @property string $bank_name
 * @property string $branch
 * @property integer $province
 * @property integer $city
 * @property integer $area
 * @property integer $addtime
 * @property string $addip
 */
class Bankcard extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'web_bankcard';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'realname', 'account', 'bank', 'bank_name', 'branch', 'province', 'city', 'area', 'addtime', 'addip'], 'required'],
            [['user_id', 'bank_type', 'province', 'city', 'area', 'addtime'], 'integer'],
            [['realname', 'account', 'bank', 'addip'], 'string', 'max' => 100],
            [['bank_name', 'branch'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'realname' => 'Realname',
            'account' => 'Account',
            'bank' => 'Bank',
            'bank_type' => 'Bank Type',
            'bank_name' => 'Bank Name',
            'branch' => 'Branch',
            'province' => 'Province',
            'city' => 'City',
            'area' => 'Area',
            'addtime' => 'Addtime',
            'addip' => 'Addip',
        ];
    }

    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->addtime = time();
            $this->area = 0;
            $this->addip = \Yii::$app->request->userIP;
        }
        return parent::beforeSave($insert);
        
    }

}
