<?php

namespace app\modules\wechat\services;

use common\models\User;
use common\models\Account;
use app\modules\wechat\components\WechatCheck;
use common\models\ProductCoupon;

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
        $strTitle = "恭喜您！获得一份春节红包抽奖券！";
        $strDes = "xxx";
        $strPicurl = "https://mmbiz.qlogo.cn/mmbiz/3Nsx3YNMeOv6rg4at4Txeak4b9Wkiaq9ibIw7z3V0jFgoXRnCoAfs06y6VRYdzbsSicMRia4nIAyDzkzcjMxzdA3aw/0?wx_fmt=jpeg";
        $strUrl = "http://mp.weixin.qq.com/s?__biz=MzAwNDU3NjAwMw==&mid=402239047&idx=1&sn=96477c6d8807242d4bd75ecf021fbde0#rd";
        $time = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        if ((int) $pertime === $time) {
            $strTitle = "您今天已经抽过奖了,请明天再来吧。";
            $strDes = "已经抽过奖了";
            $strPicurl = "https://mmbiz.qlogo.cn/mmbiz/3Nsx3YNMeOv6rg4at4Txeak4b9Wkiaq9ibIw7z3V0jFgoXRnCoAfs06y6VRYdzbsSicMRia4nIAyDzkzcjMxzdA3aw/0?wx_fmt=jpeg";
            $strUrl = "http://mp.weixin.qq.com/s?__biz=MzAwNDU3NjAwMw==&mid=402239047&idx=1&sn=96477c6d8807242d4bd75ecf021fbde0#rd";
        } else {
            $result = rand(1, 10);
            if ($result === 1) {
                $newCoupon = new ProductCoupon();
                $newCoupon->cash_id = 0;
                $newCoupon->user_id = $weixinuser->user_id;
                $newCoupon->off_rate = '100';
                $newCoupon->status = 0;
                $newCoupon->type = 0;
                $newCoupon->addtime = time();
                if ($newCoupon->validate() && $newCoupon->save()) {
                    $strTitle = "恭喜您！获得一份春节红包抽奖券！";
                    $strDes = "获得一份春节红包抽奖券";
                    $strPicurl = "https://mmbiz.qlogo.cn/mmbiz/3Nsx3YNMeOv6rg4at4Txeak4b9Wkiaq9ibIw7z3V0jFgoXRnCoAfs06y6VRYdzbsSicMRia4nIAyDzkzcjMxzdA3aw/0?wx_fmt=jpeg";
                    $strUrl = "http://mp.weixin.qq.com/s?__biz=MzAwNDU3NjAwMw==&mid=402239047&idx=1&sn=96477c6d8807242d4bd75ecf021fbde0#rd";
                } else {
                    $strTitle = "命中失败,再抽一次！";
                    $strDes = "再抽一次";
                }
            } else {
                $strTitle = "很遗憾，今天又没中奖,这是个鸟系统抽了N次不中,无聊割草！";
                $strDes = "今天又没中奖";
            }
            $result = User::updateAll(["purview" => $time], " user_id=:user_id", [':user_id' => $weixinuser->user_id]);
            if (!$result) {
                $strTitle = "命中失败,再抽一次！";
                $strDes = "再抽一次";
            }
        }
        $content = [
            0 => [
                'title' => $strTitle, 'des' => $strDes, 'picurl' => $strPicurl, 'url' => $strUrl
            ],
            1 => [
                'title' => '春节初一至初十五天天抽奖。抽完为止。', 'des' => 'ooo', 'picurl' => 'https://mmbiz.qlogo.cn/mmbiz/3Nsx3YNMeOv6rg4at4Txeak4b9Wkiaq9ib9tjFrJOGZQmfeAC4WapMdKMA7ZkfBLjicel4rwxdicOxhCHN3Z1y1rTQ/0?wx_fmt=jpeg', 'url' => ''
            ],
            2 => [
                'title' => '免费获取各种商品打折券，春节就要省省省。', 'des' => 'xxx', 'picurl' => 'https://mmbiz.qlogo.cn/mmbiz/3Nsx3YNMeOv6rg4at4Txeak4b9Wkiaq9ibuiamOrlB3usT9VuzibYFdAn0EFAANbic6C94U969Iy9oIqIUJa80N15cg/0?wx_fmt=jpeg', 'url' => ''
            ]
        ];
        WechatCheck::_transmitArticleAndPic($object, $content);
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
