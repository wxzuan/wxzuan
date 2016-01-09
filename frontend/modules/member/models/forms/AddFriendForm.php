<?php

namespace frontend\modules\member\models\forms;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Friend;


/**
 * ContactForm is the model behind the contact form.
 */
class AddFriendForm extends Model {

    public $username;
    public $user_id;

    function __construct($config = array()) {
        parent::__construct($config);
        $this->user_id = Yii::$app->user->getId();
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required', 'message' => '{attribute}不能空'],
            ['username', 'UsernameRight'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'username' => '好友用户名'
        ];
    }

    /**
     * 验证用户是否合法
     */
    public function UsernameRight() {
        $friendUser = User::find()->where("username=:username AND type_id=2", [':username' => $this->username])->one();
        if (!$friendUser) {
            $this->addError('username', '没有这个用户');
            return false;
        }
        $userCount = Friend::find()->where("user_id=:user_id AND friend_id=:friend_id", [':user_id' => $this->user_id, ':friend_id' => $friendUser->user_id])->count();
        
        if ($userCount > 0) {
            $this->addError('username', '该用户已经是您的好友');
            return FALSE;
        }
    }

    /**
     * 添加好友
     * @return boolean
     */
    public function addFriend() {
        $friendUser = User::find()->where("username=:username AND type_id=2", [':username' => $this->username])->one();
        $userCount = Friend::find()->where("user_id=:user_id AND friend_id=:friend_id", [':user_id' => $this->user_id, ':friend_id' => $friendUser->user_id])->count();
        if ($userCount > 0) {
            return TRUE;
        }
        $newFreind = new Friend();
        $newFreind->user_id = $this->user_id;
        $newFreind->friend_id = $friendUser->user_id;
        $newFreind->addtime = time();
        $newFreind->addip = \Yii::$app->request->userIp;
        if ($newFreind->save()) {
            return true;
        } else {
            $this->addError("username", '添加失败,请重试');
            return FALSE;
        }
    }

}
