<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "web_product".
 *
 * @property integer $product_id
 * @property integer $product_user_id
 * @property integer $product_type
 * @property string $product_name
 * @property string $product_s_img
 * @property string $product_m_img
 * @property string $product_b_img
 * @property string $product_price
 * @property string $product_description
 * @property string $product_info
 * @property integer $product_num
 * @property integer $product_status
 * @property integer $product_addtime
 * @property string $product_addip
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'web_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_user_id', 'product_type', 'product_num', 'product_status', 'product_addtime'], 'integer'],
            [['product_name'], 'required'],
            [['product_price'], 'number'],
            [['product_info'], 'string'],
            [['product_name', 'product_addip'], 'string', 'max' => 100],
            [['product_s_img'], 'string', 'max' => 255],
            [['product_m_img', 'product_b_img'], 'string', 'max' => 225],
            [['product_description'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'product_user_id' => 'Product User ID',
            'product_type' => 'Product Type',
            'product_name' => 'Product Name',
            'product_s_img' => 'Product S Img',
            'product_m_img' => 'Product M Img',
            'product_b_img' => 'Product B Img',
            'product_price' => 'Product Price',
            'product_description' => 'Product Description',
            'product_info' => 'Product Info',
            'product_num' => 'Product Num',
            'product_status' => 'Product Status',
            'product_addtime' => 'Product Addtime',
            'product_addip' => 'Product Addip',
        ];
    }
}
