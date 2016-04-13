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
 * @property integer $product_country
 * @property integer $product_province
 * @property integer $product_city
 * @property integer $product_area
 * @property integer $product_status
 * @property integer $product_addtime
 * @property string $product_addip
 */
class Product extends \yii\db\ActiveRecord {

    /**
     * return string
     */
    public function getProductStatus() {
        if ($this->product_status == 1) {
            return '销售中';
        } else {
            return '审核中';
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'web_product';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['product_user_id', 'product_type', 'product_num', 'product_country', 'product_province', 'product_city', 'product_area', 'product_status', 'product_addtime'], 'integer'],
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
    public function attributeLabels() {
        return [
            'product_id' => '商品ID',
            'product_user_id' => '商品提供者',
            'product_type' => '产品类型',
            'product_name' => '产品名称',
            'product_s_img' => '产品小图',
            'product_m_img' => '产品中图',
            'product_b_img' => '产品大图',
            'product_price' => '产品价格',
            'product_description' => '商品描述',
            'product_info' => '商品信息',
            'product_num' => '商品数量',
            'product_country' => '所在国家',
            'product_province' => '所在省份',
            'product_city' => '所在城市',
            'product_area' => '所在区域',
            'product_status' => '是否审核通过',
            'product_addtime' => '商品上架时间',
            'product_addip' => '商品添加IP',
        ];
    }

    /**
     * 
     * @param type $insert
     * @return type
     */
    public function beforeSave($insert) {
        if ($this->isNewRecord) {
            $this->product_type = 0;
            $this->product_user_id = Yii::$app->user->getId();
            $this->product_status = 0;
            $this->product_addtime = time();
            $this->product_addip = Yii::$app->request->userIP;
        }
        return parent::beforeSave($insert);
    }

}
