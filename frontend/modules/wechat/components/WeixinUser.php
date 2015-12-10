<?php
namespace app\modules\wechat\components;
//---------------------------------Wechat----------------------------------------
class WeixinUser {

    private static $weixinUser;

    /**
     * 
     * @return type
     * 获得一个发送信息的单例
     */
    public static function getInstance() {
        if (self::$weixinUser) {
            return self::$weixinUser;
        } else {
            self::$weixinUser = new WeixinUser();
            return self::$weixinUser;
        }
    }

    /**
     * 获得一个用户
     */
    public function getUser($weixinid) {
        $user = User::model()->find("wangwang=:weixin_open_id AND `status`=1", array(":weixin_open_id" => $weixinid));

        return $user;
    }

}