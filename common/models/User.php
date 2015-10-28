<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_user".
 *
 * @property integer $user_id
 * @property integer $type_id
 * @property integer $super_type_id
 * @property integer $credit
 * @property string $purview
 * @property string $username
 * @property string $nickname
 * @property string $password
 * @property string $paypassword
 * @property integer $islock
 * @property integer $real_status
 * @property integer $card_type
 * @property string $card_id
 * @property string $card_pic1
 * @property string $card_pic2
 * @property string $nation
 * @property string $realname
 * @property integer $email_status
 * @property integer $phone_status
 * @property integer $video_status
 * @property string $email
 * @property integer $sex
 * @property string $litpic
 * @property string $tel
 * @property string $phone
 * @property integer $qq
 * @property string $wangwang
 * @property string $question
 * @property string $answer
 * @property string $birthday
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $address
 * @property string $remind
 * @property string $privacy
 * @property string $regtaken
 * @property integer $regativetime
 * @property string $repstaken
 * @property integer $repsativetime
 * @property integer $logintime
 * @property integer $addtime
 * @property string $addip
 * @property integer $uptime
 * @property string $upip
 * @property integer $lasttime
 * @property string $lastip
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'super_type_id', 'credit', 'islock', 'real_status', 'card_type', 'email_status', 'phone_status', 'video_status', 'sex', 'qq', 'regativetime', 'repsativetime', 'logintime', 'addtime', 'uptime', 'lasttime'], 'integer'],
            [['username', 'password'], 'required'],
            [['purview', 'username', 'nickname', 'password', 'paypassword', 'card_id', 'nation', 'realname', 'tel', 'phone', 'question', 'province', 'city', 'area', 'remind', 'privacy'], 'string', 'max' => 100],
            [['card_pic1', 'card_pic2', 'email', 'litpic', 'wangwang', 'answer', 'birthday', 'address', 'regtaken', 'repstaken', 'addip', 'upip', 'lastip'], 'string', 'max' => 255],
            [['username'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'type_id' => 'Type ID',
            'super_type_id' => 'Super Type ID',
            'credit' => 'Credit',
            'purview' => 'Purview',
            'username' => 'Username',
            'nickname' => 'Nickname',
            'password' => 'Password',
            'paypassword' => 'Paypassword',
            'islock' => 'Islock',
            'real_status' => 'Real Status',
            'card_type' => 'Card Type',
            'card_id' => 'Card ID',
            'card_pic1' => 'Card Pic1',
            'card_pic2' => 'Card Pic2',
            'nation' => 'Nation',
            'realname' => 'Realname',
            'email_status' => 'Email Status',
            'phone_status' => 'Phone Status',
            'video_status' => 'Video Status',
            'email' => 'Email',
            'sex' => 'Sex',
            'litpic' => 'Litpic',
            'tel' => 'Tel',
            'phone' => 'Phone',
            'qq' => 'Qq',
            'wangwang' => 'Wangwang',
            'question' => 'Question',
            'answer' => 'Answer',
            'birthday' => 'Birthday',
            'province' => 'Province',
            'city' => 'City',
            'area' => 'Area',
            'address' => 'Address',
            'remind' => 'Remind',
            'privacy' => 'Privacy',
            'regtaken' => 'Regtaken',
            'regativetime' => 'Regativetime',
            'repstaken' => 'Repstaken',
            'repsativetime' => 'Repsativetime',
            'logintime' => 'Logintime',
            'addtime' => 'Addtime',
            'addip' => 'Addip',
            'uptime' => 'Uptime',
            'upip' => 'Upip',
            'lasttime' => 'Lasttime',
            'lastip' => 'Lastip',
        ];
    }
}
