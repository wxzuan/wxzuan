<?php

namespace common\models\forms;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\image\drivers\Image;
use common\models\Pic;
use common\services\ToolService;

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
    private $o_img_url;
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
     * save userPIC
     * return boolen
     */
    public function userSave() {
        $user_id = \Yii::$app->user->getId();
        $baseimgurl = 'date/upload/wechat/user/';
        $createpath=\Yii::$app->basePath.'/web/'.$baseimgurl;
        ToolService::createdir($createpath, 775);
        //生成随机文件名
        $basefilename = $user_id . '_' . time() . '_' . rand(1000, 9999);
        $this->s_img_url = $sfilename = $baseimgurl . 's' . $basefilename . '.' . $this->file->extension;
        $this->o_img_url = $ofilename = $baseimgurl . 'o' . $basefilename . '.' . $this->file->extension;
        $this->m_img_url = $mfilename = $baseimgurl . 'm' . $basefilename . '.' . $this->file->extension;
        $this->b_img_url = $bfilename = $baseimgurl . 'b' . $basefilename . '.' . $this->file->extension;
        $this->file->saveAs($bfilename);
        $image = \Yii::$app->image->load($bfilename);
        //生成中图片
        $image->resize(100, 100, Image::NONE);
        $image->save($mfilename);
        //生成小图片
        $image->resize(64, 64, Image::NONE);
        $image->save($sfilename);
        //生成微略图
        $image->resize(48, 48, Image::NONE);
        $image->save($ofilename);


        $newpic = new Pic();
        $newpic->setAttributes([
            'user_id' => $user_id,
            'pic_type' => 1,
            'pic_s_img' => '/' . $sfilename,
            'pic_m_img' => '/' . $mfilename,
            'pic_b_img' => '/' . $bfilename
        ]);
        if ($newpic->save()) {
            $this->id = \Yii::$app->db->getLastInsertID();
            return true;
        }
        return FALSE;
    }
    /**
     * save productPIC
     * return boolen
     */
    public function logisticsSave() {
        $user_id = \Yii::$app->user->getId();
        $baseimgurl = 'date/upload/wechat/logis/';
        $basefilename = $user_id . '_' . time() . '_' . rand(1000, 9999);
        $this->s_img_url = $sfilename = $baseimgurl . 's' . $basefilename . '.' . $this->file->extension;
        $this->o_img_url = $ofilename = $baseimgurl . 'o' . $basefilename . '.' . $this->file->extension;
        $this->m_img_url = $mfilename = $baseimgurl . 'm' . $basefilename . '.' . $this->file->extension;
        $this->b_img_url = $bfilename = $baseimgurl . 'b' . $basefilename . '.' . $this->file->extension;
        $this->file->saveAs($bfilename);
        $image = \Yii::$app->image->load($bfilename);
        //生成中图片
        $image->resize(900, 600, Image::NONE);
        $image->save($mfilename);
        //生成小图片
        $image->resize(450, 300, Image::NONE);
        $image->save($sfilename);
        //生成微略图
        $image->resize(90, 60, Image::NONE);
        $image->save($ofilename);


        $newpic = new Pic();
        $newpic->setAttributes([
            'user_id' => $user_id,
            'pic_type' => 2,
            'pic_s_img' => '/' . $sfilename,
            'pic_m_img' => '/' . $mfilename,
            'pic_b_img' => '/' . $bfilename
        ]);
        if ($newpic->save()) {
            $this->id = \Yii::$app->db->getLastInsertID();
            return true;
        }
        return FALSE;
    }
    /**
     * save productPIC
     * return boolen
     */
    public function productSave() {
        $user_id = \Yii::$app->user->getId();
        $baseimgurl = 'date/upload/wechat/product/';
        //生成随机文件名
        $basefilename = $user_id . '_' . time() . '_' . rand(1000, 9999);
        $this->s_img_url = $sfilename = $baseimgurl . 's' . $basefilename . '.' . $this->file->extension;
        $this->o_img_url = $ofilename = $baseimgurl . 'o' . $basefilename . '.' . $this->file->extension;
        $this->m_img_url = $mfilename = $baseimgurl . 'm' . $basefilename . '.' . $this->file->extension;
        $this->b_img_url = $bfilename = $baseimgurl . 'b' . $basefilename . '.' . $this->file->extension;
        $this->file->saveAs($bfilename);
        $image = \Yii::$app->image->load($bfilename);
        //生成中图片
        $image->resize(900, 600, Image::NONE);
        $image->save($mfilename);
        //生成小图片
        $image->resize(450, 300, Image::NONE);
        $image->save($sfilename);
        //生成微略图
        $image->resize(90, 60, Image::NONE);
        $image->save($ofilename);


        $newpic = new Pic();
        $newpic->setAttributes([
            'user_id' => $user_id,
            'pic_type' => 0,
            'pic_s_img' => '/' . $sfilename,
            'pic_m_img' => '/' . $mfilename,
            'pic_b_img' => '/' . $bfilename
        ]);
        if ($newpic->save()) {
            $this->id = \Yii::$app->db->getLastInsertID();
            return true;
        }
        return FALSE;
    }

    /**
     * 获得中等图片
     * @return string
     */
    public function getImageUrl() {
        return $this->m_img_url;
    }

    /**
     * 获得缩略图
     * @return  string
     */
    public function getOImageUrl() {
        return $this->o_img_url;
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
