<?php

namespace app\modules\wechat\services;

use common\models\User;
use common\models\Account;
use app\modules\wechat\components\WechatCheck;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WeixinKeyWordService
 *
 * @author Administrator
 */
class WeixinClickService {

    public static function fitEvent($object, $weixinuser) {
        switch ($object->EventKey) {
            #更多功能
            case 'weixin_userlogin':
                $repaydata = self::getLoginUrl($object, $weixinuser);
                break;
            #可用金额
            case 'weixin_clickone':
                $repaydata = self::getRollRestul($object, $weixinuser);
                break;
            #今日待还
            case 'weixin_clicktwo':
                $repaydata = self::getRollRestul($object, $weixinuser);
                break;
            #今日待收
            case 'weixin_clickthree':
                $repaydata = self::getRollRestul($object, $weixinuser);
                break;
            case 'weixin_usemoney':
                $repaydata = self::getAccountClick($object, $weixinuser);
                break;
            case 'weixin_sharp':
                $repaydata = self::getSharpPic($object, $weixinuser);
                break;
            case 'weixin_alias':
                $repaydata = self::getSharpPic($object, $weixinuser);
                break;
            default :
                $repaydata = self::getDefaultClick($object, $weixinuser);
                break;
        }
    }

    /**
     * 
     * @return type
     */
    public static function getLoginUrl($obj, $user) {
        #增加用户的验证依据
        $randstring = rand(10000, 99999);
        $mdstring = md5($randstring . $user->user_id);
        $result = User::updateAll(["repstaken" => $mdstring, "repsativetime" => time()], " user_id=:user_id", [':user_id' => $user->user_id]);
        if ($result) {
            $content = '请在10秒内进入>> <a href="http://wxzuan.zuanzuanle.com/public/login/' . $user->user_id . '/' . $mdstring . '.html">首页</a>,否则授权将失效。';
        } else {
            $content = "无法获得授权,请重新获取...";
        }

        WechatCheck::_transmitText($obj, $content);
    }

    /**
     * 
     * @param type $object
     * @return string
     */
    public static function getAccountClick($object, $weixinuser) {
        $myAccount = Account::find()->where("user_id=:user_id", [":user_id" => $weixinuser->user_id])->one();
        $content = "我的总金额为：" . $myAccount->total . "\n" . "可用资金为：" . $myAccount->use_money;
        WechatCheck::_transmitText($object, $content);
    }

    /**
     * 
     * @return string
     */
    public static function getDefaultClick($object, $weixinuser) {
        $content = "亲爱的赚赚乐平台用户：该功能还没有实现呢。";
        WechatCheck::_transmitText($object, $content);
    }

    /**
     * 
     */
    public static function getRollRestul($object, $weixinuser) {
        #增加今天是否已经抽过奖的处理
        $pertime = $weixinuser->purview;

        $time = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        if ((int) $pertime === $time) {
            $content = "亲爱的用户,您今天已经抽过奖啦,请明天再来试试吧!";
        } else {
            $result = rand(1, 10);
            if ($result === 1) {
                $content = "恭喜您：中奖啦，您将获得本平台提供的免费商品,马上去发货。";
            } else {
                $content = "很遗憾，今天又没中奖,这是个鸟系统抽了N次不中,无聊割草！";
            }
            $result = User::updateAll(["purview" => $time], " user_id=:user_id", [':user_id' => $weixinuser->user_id]);
            if (!$result) {
                $content = "命中失败,再抽一次！";
            }
        }
        WechatCheck::_transmitText($object, $content);
    }

    /**
     * 
     * @param type $object
     * @param type $weixinuser
     */
    public static function getSharpPic($object, $weixinuser) {
        self::getDefaultClick($object, $weixinuser);
    }

}

?>
