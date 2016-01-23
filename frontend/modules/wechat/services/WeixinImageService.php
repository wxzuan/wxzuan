<?php
namespace app\modules\wechat\services;
use common\models\Pic;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WeixinKeyWordService
 *
 * @author Administrator
 */
class WeixinImageService {

    /**
     * 微信处理图片
     */
    public static function fitImage($obj, Users $user) {
        #判断图片是否开启
        $pic_save_status = \Yii::$app->cache->get("qys_pic_save_" . $user->user_id);
        $count = Pic::find()->where("user_id=:user_id", array(":user_id" => $user->user_id))->count("*");
        if ($pic_save_status == false) {
            $content = "没有开启保存图片功能,该图片不会被服务器保存.";
        }elseif($count >= 20){
            $content = "图片已经超过20张,不再做保存。";
        } else {
            $count = Pic::find()->where("user_id=:user_id", array(":user_id" => $user->user_id))->count("*");
            #获得图片地址
            $pic = file_get_contents($obj->PicUrl);
            $picname = time() . "_" . $user->user_id . ($count + 1) . ".gif";
            $pic_path = Yii::getPathOfAlias('webroot') . '/date/uplaod/';
            $pic_show_path = '/date/uplaod/';
            file_put_contents($pic_path . $picname, $pic);
            if (file_exists($pic_path . $picname)) {
                #小图保存
                $simage = Yii::app()->image->load($pic_path . $picname);
                $simage->resize(80, 80);
                $simage->save($pic_path . "s_" . $picname);
#中图保存
                $mimage = Yii::app()->image->load($pic_path . $picname);
                $mimage->resize(240, 240);
                $mimage->save($pic_path . "m_" . $picname);
#大图保存
                $bimage = Yii::app()->image->load($pic_path . $picname);
                $bimage->save($pic_path . "b_" . $picname);
                $userPic = New Pic();
                $picArray = array(
                    'user_id' => $user->user_id,
                    'pic_type' => 0,
                    'pic_s_img' => $pic_show_path . "s_" . $picname,
                    'pic_m_img' => $pic_show_path . "m_" . $picname,
                    'pic_b_img' => $pic_show_path . "n_" . $picname,
                );
                $userPic->setAttributes($picArray);
                if ($userPic->validate() && $userPic->save()) {
                    $content = "图片已经保存。";
                } else {
                    $content = "图片保存失败,请重新发送。";
                }
            } else {
                $content = "保存失败。";
            }
            unlink($pic_path . $picname);
        }
        WechatCheck::_transmitText($obj, $content);
    }

}

?>
