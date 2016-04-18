<?php

namespace common\models;

use Yii;
use yii\web\IdentityInterface;

//use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "web_user".
 *
 * @property string $user_id
 * @property integer $type_id
 * @property string $hash_token
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
class User extends \yii\db\ActiveRecord implements IdentityInterface {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'web_user';
    }

    /**
     * @inheritdoc
     */
    //public function behaviors() {
    //    return [
    //        TimestampBehavior::className(),
    //    ];
    //}

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['type_id', 'super_type_id', 'credit', 'islock', 'real_status', 'card_type', 'email_status', 'phone_status', 'video_status', 'sex', 'qq', 'regativetime', 'repsativetime', 'logintime', 'addtime', 'uptime', 'lasttime'], 'integer'],
            [['username', 'password'], 'required'],
            [['purview',  'nickname', 'password', 'paypassword', 'card_id', 'nation', 'realname', 'tel', 'phone', 'question', 'province', 'city', 'area', 'remind', 'privacy'], 'string', 'max' => 100],
            [['card_pic1', 'card_pic2', 'email', 'litpic', 'answer', 'birthday', 'address', 'regtaken', 'repstaken', 'addip', 'upip', 'lastip'], 'string', 'max' => 255],
            [['username'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'user_id' => 'User ID',
            'type_id' => 'Type ID',
            'hash_token' => 'Hash Token',
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

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['user_id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'is_lock' => 1]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        if ($this->hash_token == '0') {
            $this->generateAuthKey();
            $this->privacy = uniqid();
        }
        return $this->hash_token;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        if ($this->generatePassword($password) == $this->password) {
            return true;
        }
        return false;
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password = $this->generatePassword($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->hash_token = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    public function generatePassword($password) {
        return sha1(md5(sha1(md5($password)) . $this->getAuthKey()) . $this->privacy);
    }

}
