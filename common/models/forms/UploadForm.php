<?php

namespace common\models\forms;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\image\drivers\Image;

/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends Model {

    /**
     * @var UploadedFile file attribute
     */
    public $file;
    private $m_img_url;
    private $s_img_url;
    private $b_img_url;
    private $id;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            ['file', 'file', 'uploadRequired' => FALSE, 'extensions' => 'jpg,png,gif,bmp', 'maxSize' => 1024 * 1024 * 2, 'tooBig' => '2M', 'on' => 'picupload'],
        ];
    }

    /**
     * save productPIC
     * return boolen
     */
    public function productSave() {
        $baseimgurl = 'date/upload/wechat/product/';
        $this->file->saveAs($baseimgurl . 'bababa.jpg');
        $image = \Yii::$app->image->load($baseimgurl . 'bababa.jpg');
        $image->resize(450,300,  Image::NONE);
        $image->save($baseimgurl . 'bababawww.jpg');
    }

    /**
     * 获得中等图片
     * @return string
     */
    public function getImageUrl() {
        return $this->m_img_url;
    }

    /**
     * 获得小图片
     * @return  string
     */
    public function getSmallImageUrl() {
        return $this->s_img_url;
    }

    /**
     * 获得图片的ID
     * @return integer
     */
    public function getID() {
        return $this->id;
    }

}