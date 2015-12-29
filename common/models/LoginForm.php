<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model {

    public $username;
    public $password;
    public $rememberMe = true;
    private $_user;
    private $type = 0;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'username' => '帐号',
            'rememberMe' => '记住帐号',
            'password' => '密码',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser($this->type);
            if ($this->type == 2) {
                if (!$user) {
                    $this->addError($attribute, '用户名或者密码错误。');
                }
            } else {
                if (!$user || !$user->validatePassword($this->password)) {
                    $this->addError($attribute, '用户名或者密码错误。');
                }
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login($type = 0) {
        if ($type != 0) {
            $this->type = $type;
        }
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser() {
        if ($this->_user === null) {
            switch ($this->type) {
                case 0:
                    $this->_user = User::find()->where("username=:username", [':username' => $this->username])->one();
                    break;
                case 1:
                    $this->_user = User::find()->where("username=:username AND type_id=1", [':username' => $this->username])->one();
                    break;
                case 2:
                    $this->_user = User::find()->where("username=:username", [':username' => $this->username])->one();
                    break;
                default :
                    $this->_user = User::find()->where("username=:username", [':username' => $this->username])->one();
            }
        }

        return $this->_user;
    }

}
