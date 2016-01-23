<?php

namespace common\models;

use Yii;
use common\models\Product;

/**
 * This is the model class for table "web_product_order".
 *
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $user_id
 * @property integer $p_user_id
 * @property string $order_price
 * @property string $order_pay_price
 * @property integer $coupon_id
 * @property integer $order_status
 * @property string $realname
 * @property string $phone
 * @property string $address
 * @property integer $addtime
 * @property string $addip
 */
class ProductOrder extends \yii\db\ActiveRecord {

    public function getProduct() {
        /**
         * 第一个参数为要关联的字表模型类名称，
         * 第二个参数指定 通过子表的 customer_id 去关联主表的 id 字段
         */
        return $this->hasOne(Product::className(), ['product_id' => 'product_id']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'web_product_order';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['product_id', 'user_id'], 'required'],
            [['product_id', 'user_id', 'p_user_id', 'coupon_id', 'order_status', 'addtime'], 'integer'],
            [['order_price', 'order_pay_price'], 'number'],
            [['realname', 'phone', 'addip'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'user_id' => 'User ID',
            'p_user_id' => 'P User ID',
            'order_price' => 'Order Price',
            'order_pay_price' => 'Order Pay Price',
            'coupon_id' => 'Coupon ID',
            'order_status' => 'Order Status',
            'realname' => 'Realname',
            'phone' => 'Phone',
            'address' => 'Address',
            'addtime' => 'Addtime',
            'addip' => 'Addip',
        ];
    }

    /**
     * 订单处理状态，未成功
     * @return string
     */
    function getOrderStatus() {
        if ($this->order_status == 1) {
            return '已完成';
        } else {
            return '处理中';
        }
    }

}
