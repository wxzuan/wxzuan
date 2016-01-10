<?php

namespace frontend\modules\member\models\forms;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * ContactForm is the model behind the contact form.
 */
class UserInfoForm extends Model {

    public $username;
    public $province;
    public $city;
    public $area;
    public $address;
    public $question;
    public $answer;
    public $user_id;

    /**
     * 更新用户信息
     * @return boolean
     */
    public function update(User $user) {
        $user->setAttributes($this->attributes);
        return $user->update();
    }

    /**
     * 验证用户是否合法
     */
    public function UsernameRight() {
        $post=\Yii::$app->request->post();
        $thisuser=User::find()->where("user_id=:user_id", [':user_id' => $this->user_id])->one();
        if($thisuser->username!=$thisuser->wangwang){
            $this->addError('username', '你已经更改过用户名,不允许再次更改！');
            return false;
        }
        $user = User::find()->where("username=:username AND type_id=2 AND user_id<>:user_id", [':username' => $this->username, ':user_id' => $this->user_id])->one();
        if ($user) {
            $this->addError('username', '用户名已经被使用');
            return false;
        }
        $this->province=$post['province'];
        $this->city=$post['city'];
        $this->area=$post['area'];
    }

    function __construct($config = array()) {
        parent::__construct($config);
        $this->user_id = Yii::$app->user->getId();
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['username', 'address', 'answer'], 'filter', 'filter' => 'trim'],
            [['username', 'answer'], 'required', 'message' => '{attribute}不能空'],
            ['username', 'string', 'min' => 8, 'max' => 50, 'message' => '{attribute}在8至50个字符之间'],
            [ 'answer', 'string', 'min' => 4, 'max' => 50, 'message' => '{attribute}在4至50个字符之间'],
            ['username', 'match', 'pattern' => '/^[a-z\d_]{8,30}$/', 'message' => '用户名只能为数字字母下划线'],
            ['username', 'UsernameRight'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'username' => '用户名',
            'province' => '省份代号',
            'city' => '城市代号',
            'area' => '地区代号',
            'address' => '真实地址',
            'question' => '密保问题',
            'answer' => '密保答案'
        ];
    }

}
