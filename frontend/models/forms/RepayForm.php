<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Comment;
use common\models\Friend;

/**
 * ContactForm is the model behind the contact form.
 */
class RepayForm extends Model {

    public $c_content;
    public $user_id;
    public $top_id;

    function __construct($config = array()) {
        parent::__construct($config);
        $this->user_id = Yii::$app->user->getId();
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['c_content', 'top_id'], 'required'],
            ['top_id', 'integer'],
            [['c_content'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'c_content' => '回复内容',
        ];
    }

    /**
     * 保存商品
     */
    public function save() {
        $newComent = new Comment();
        $newComent->setAttributes($this->attributes);
        //获得对应回复ID的信息
        $upComment = Comment::find()->where('id=:id', [':id' => $this->top_id])->one();
        if (!$upComment) {
            return FALSE;
        }
        //设置title
        $newComent->setAttribute('c_title', $this->user_id . ',' . $upComment->c_title);
        //设置to_user_id
        $newComent->setAttribute('to_user_id', $upComment->user_id);
        $newComent->setAttribute("c_type", 'pinrun');
        $newComent->setAttribute("is_public", $upComment->is_public);
        $newComent->setAttribute("c_nums", 0);
        $newComent->setAttribute("c_addtime", date('Y-m-d H:i:s'));
        if ($newComent->save()) {
            $upComment->update(['c_nums' => $upComment->c_nums + 1]);
            return $this->top_id;
        } else {
            return FALSE;
        }
    }

}
