<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Comment;
use common\models\Friend;

/**
 * ContactForm is the model behind the contact form.
 */
class SayingForm extends Model {

    public $user_id;
    public $to_user_id;
    public $is_public;
    public $c_title;
    public $c_content;

    function __construct($config = array()) {
        parent::__construct($config);
        $this->user_id = Yii::$app->user->getId();
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_title', 'c_content'], 'required'],
            [['to_user_id', 'is_public'], 'integer'],
            [['c_title'], 'string', 'max' => 255],
            [['c_content'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'to_user_id' => '收信人',
            'is_public' => '是否公开',
            'c_title' => '标题',
            'c_content' => '评论内容',
        ];
    }

    /**
     * 获得活动分类
     * @return type
     */
    public function showUsername() {
        $fitArray = [];
        $result = Friend::find()->where('user_id=:user_id', [':user_id' => $this->user_id])->indexBy('id')->all();
        if ($result) {
            foreach ($result as $key => $value) {
                $fitArray[$value->friend_id] = $value->user->username;
            }
        }
        $fitArray[0] = '所有用户';
        return $fitArray;
    }

    /**
     * 保存商品
     */
    public function save() {
        $newComent = new Comment();
        $newComent->setAttributes($this->attributes);
        $newComent->setAttribute('c_type', 'article');
        $newComent->setAttribute("c_addtime", date('Y-m-d H:i:s'));
        if ($newComent->save()) {
            $logisct_id = \Yii::$app->db->lastInsertID;
            return $logisct_id;
        } else {
            return FALSE;
        }
    }

}
