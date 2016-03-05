<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use common\models\Product;

/**
 * ContactForm is the model behind the contact form.
 */
class AddProductForm extends Model {

    public $product_name;
    public $product_price;
    public $product_num;
    public $product_description;
    public $product_info;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['product_name', 'product_price', 'product_num', 'product_description', 'product_info'], 'filter', 'filter' => 'trim'],
            [['product_name', 'product_price', 'product_num', 'product_description', 'product_info'], 'required', 'message' => '{attribute}不能空'],
            ['product_name', 'string', 'min' => 2, 'max' => 100, 'message' => '{attribute}在2至100个字符之间'],
            ['product_price', 'match', 'pattern' => '/^(([1-9]\d{0,9})|0)(\.\d{1,2})?$/', 'message' => '请输入有效的金额'],
            ['product_price', 'string', 'min' => 1, 'max' => 10, 'message' => '{attribute}在1至10个字符之间'],
            [['product_description', 'product_info'], 'string', 'max' => 60000],
            ['product_num', 'match', 'pattern' => '/^([1-9][0-9]{0,4}|0)$/', 'message' => '请输入有效的数量'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'product_name' => '商品名称',
            'product_price' => '商品价格',
            'product_num' => '商品数量',
            'product_description' => '商品简介',
            'product_info' => '商品详情'
        ];
    }

    /**
     * 保存商品
     */
    public function save() {
        #获得用户的地区信息用来提供浏览者的显示信息
        $userinfo = \Yii::$app->user->getIdentity();
        $newProduct = new Product();
        $newProduct->product_country = 0;
        if (!empty($userinfo->province)) {
            $newProduct->product_province = $userinfo->province;
        }
        if (!empty($userinfo->city)) {
            $newProduct->product_city = $userinfo->city;
        }
        if (!empty($userinfo->area)) {
            $newProduct->product_area = $userinfo->area;
        }
        $newProduct->setAttributes($this->attributes);
        return $newProduct->save();
    }

    /**
     * 更新商品
     */
    public function update() {
        
    }

}
