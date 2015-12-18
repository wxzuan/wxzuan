<?php

namespace app\modules\wechat\services;

use common\models\User;
use app\modules\wechat\components\WechatCheck;
use app\modules\wechat\services\ClickService;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WeixinKeyWordService
 *
 * @author Administrator
 */
class WeixinEventService {

    public static function fitEvent($object, User $weixinuser) {
        switch ($object->Event) {
            #自定义菜单处理
            case 'CLICK':
                ClickService::fitEvent($object, $weixinuser);
                break;
            #关注处理
            case 'subscribe':
                self::fitSubscribe($object, $weixinuser);
                break;
            default :
                $repaydata = self::getDefaultClick($object, $weixinuser);
                break;
        }
    }

    public static function fitSubscribe($object, User $weixinuser) {
        #增加用户的验证依据
        $strTitle = "欢迎您！关注赚赚乐微信平台！";
        $strDes = "感谢您关注寻想网络科技旗下的赚赚乐微信平台,你可以查看全文获得对该平台更多的详细介绍。";
        $strPicurl = "https://mmbiz.qlogo.cn/mmbiz/3Nsx3YNMeOtfHYAIG7Zn4DhWKsRvS2HiaibGZe5yUdEicOaj8bRMEfNfzPx6rib3z8khlC49mpDUXyDTbLvxY0qiaMQ/0?wx_fmt=png";
        $strUrl = "http://mp.weixin.qq.com/s?__biz=MzAwNDU3NjAwMw==&mid=402405687&idx=1&sn=9368335e32b51186759483e6c7be0216#rd";


        $content = [
            0 => [
                'title' => $strTitle, 'des' => $strDes, 'picurl' => $strPicurl, 'url' => $strUrl
            ]
        ];
        WechatCheck::_transmitArticleAndPic($object, $content);
    }

    /**
     * 
     * @return string
     */
    public static function getDefaultClick($object, User $weixinuser) {
        $content = "亲爱的赚赚乐平台用户：该功能还没有实现呢。";
        WechatCheck::_transmitText($object, $content);
    }

}

?>
