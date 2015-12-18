<?php

namespace app\modules\wechat\services;

use common\models\User;
use common\models\Account;
use app\modules\wechat\components\WechatCheck;
use common\models\Activity;
use common\models\ActivityRemind;

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

    public static function fitEvent($object, User $weixinuser) {
        switch ($object->EventKey) {
            #更多功能
            case 'weixin_userlogin':
                $repaydata = self::getLoginUrl($object, $weixinuser);
                break;
            #抽资金
            case 'weixin_clickone':
                $repaydata = self::getRollRestul($object, $weixinuser, 1);
                break;
            #今日待还
            case 'weixin_clicktwo':
                $repaydata = self::getRollRestul($object, $weixinuser, 2);
                break;
            #今日待收
            case 'weixin_clickthree':
                $repaydata = self::getRollRestul($object, $weixinuser, 3);
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
        $strTitle = "恭喜您！获得一份春节红包抽奖券！";
        $strDes = "xxx";
        $strPicurl = "https://mmbiz.qlogo.cn/mmbiz/3Nsx3YNMeOuG8mrcZvr1icXrjCvvAj0xvZ4ZmT6jn4wVENO7ZwH7oxqicJFlNythSWBLhbuuEGvfdZxssrbGHYibQ/0?wx_fmt=jpeg";
        $strUrl = "http://mp.weixin.qq.com/s?__biz=MzAwNDU3NjAwMw==&mid=402239047&idx=1&sn=96477c6d8807242d4bd75ecf021fbde0#rd";
        $randstring = rand(10000, 99999);
        $mdstring = md5($randstring . $user->user_id);
        $result = User::updateAll(["repstaken" => $mdstring, "repsativetime" => time()], " user_id=:user_id", [':user_id' => $user->user_id]);
        if ($result) {
            $strTitle = "请在10秒内进入,否则授权将失效。";
            $strDes = '请点击阅读全文进入登录,由于微信自身原因,使用wifi登录会比较慢,切换手机自身网络会加快速度。或者请耐心等待。';
            $strUrl = 'http://wxzuan.zuanzuanle.com/public/login/' . $user->user_id . '/' . $mdstring . '.html';
        } else {
            $strTitle = "无法获得授权,请重新获取...";
            $strDes = '无法获得授权,请重新获取...';
        }

        $content = [
            0 => [
                'title' => $strTitle, 'des' => $strDes, 'picurl' => $strPicurl, 'url' => $strUrl
            ]
        ];
        WechatCheck::_transmitArticleAndPic($obj, $content);
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
    public static function getRollRestul($object, User $weixinuser, $gift_type) {

        $pertime = $weixinuser->purview;
        $fitime = mktime(0, 0, 0, date("m", $pertime), date("d", $pertime), date("Y", $pertime));
        $time = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        if ((int) $fitime === $time) {
            $reply = "您今天已经抽过奖了,请明天再来吧。";
        } else {
            #是否已经提醒过
            $activity = Activity::find()->where("ac_name=:ac_name", [':ac_name' => 'year2016'])->one();
            if (!$activity) {
                #不存在
                $reply = '这个活动不存在';
            } else {
                if (!$activity->isInDate()) {
                    $reply = $activity->isInDateRemark();
                } elseif (!$activity->isRightStatus()) {
                    $reply = $activity->isRightStatusRemark();
                } else {
                    //获得是否提醒过
                    switch ($gift_type) {
                        case 1:
                            $fitActivity = Activity::find()->where("ac_name=:ac_name", [':ac_name' => 'year2016money'])->one();
                            break;
                        case 2:
                            $fitActivity = Activity::find()->where("ac_name=:ac_name", [':ac_name' => 'year2016gift'])->one();
                            break;
                        case 3:
                            $fitActivity = Activity::find()->where("ac_name=:ac_name", [':ac_name' => 'year2016agio'])->one();
                            break;
                        default :
                            $fitActivity = Activity::find()->where("ac_name=:ac_name", [':ac_name' => 'year2016money'])->one();
                            break;
                    }
                    if (!$fitActivity) {
                        $reply = '这个活动不存在';
                    } else {
                        $remind_nums = ActivityRemind::find()->where('activity_id=:ac_id AND user_id=:user_id', [':ac_id' => $activity->id, ':user_id' => $weixinuser->user_id])->count();
                        if ($remind_nums < 1) {
                            self::toBigPicArctileShow($object, $weixinuser, $fitActivity, $activity);
                        } else {
                            $result = $activity->toRollActivity($weixinuser, $fitActivity->id);
                            $reply = $result['remark'];
                            if ($result['status'] != 2) {
                                User::updateAll(['purview' => time()], 'user_id=:user_id', [':user_id' => $weixinuser->user_id]);
                            }
                        }
                    }
                }
            }
        }
        WechatCheck::_transmitText($object, $reply);
    }

    /**
     * 
     * @param type $object
     * @param type $weixinuser
     */
    public static function getSharpPic($object, $weixinuser) {
        self::getDefaultClick($object, $weixinuser);
    }

    public static function toBigPicArctileShow($object, User $weixinuser, Activity $activity, Activity $re_activity) {
        $strPicurl = "https://mmbiz.qlogo.cn/mmbiz/3Nsx3YNMeOv6rg4at4Txeak4b9Wkiaq9ibIw7z3V0jFgoXRnCoAfs06y6VRYdzbsSicMRia4nIAyDzkzcjMxzdA3aw/0?wx_fmt=jpeg";
        $strUrl = "http://mp.weixin.qq.com/s?__biz=MzAwNDU3NjAwMw==&mid=402239047&idx=1&sn=96477c6d8807242d4bd75ecf021fbde0#rd";
        $result = $activity->toRollActivity($weixinuser, $activity->id);
        #增加提醒记录
        $activityRemind = new ActivityRemind();
        $activityRemind->setAttributes([
            'activity_id' => $re_activity->id,
            'user_id' => $weixinuser->user_id,
            'remind_name' => $re_activity->ac_name,
            'remind_mark' => $re_activity->ac_cname,
            'remind_type' => 0,
            'addtime' => time()
        ]);
        $activityRemind->save();
        if ($result['status'] != 2) {
            User::updateAll(['purview' => time()], 'user_id=:user_id', [':user_id' => $weixinuser->user_id]);
        }
        if ($result['status'] == 1) {
            $strPicurl = "https://mmbiz.qlogo.cn/mmbiz/3Nsx3YNMeOv6rg4at4Txeak4b9Wkiaq9ibIw7z3V0jFgoXRnCoAfs06y6VRYdzbsSicMRia4nIAyDzkzcjMxzdA3aw/0?wx_fmt=jpeg";
            $strUrl = "http://mp.weixin.qq.com/s?__biz=MzAwNDU3NjAwMw==&mid=402239047&idx=1&sn=96477c6d8807242d4bd75ecf021fbde0#rd";
        }
        $strTitle = $result['remark'];
        $strDes = $result['remark'];
        $content = [
            0 => [
                'title' => $strTitle, 'des' => $strDes, 'picurl' => $strPicurl, 'url' => $strUrl
            ],
            1 => [
                'title' => '春节初一至初十五天天抽奖。抽完为止。', 'des' => 'ooo', 'picurl' => 'https://mmbiz.qlogo.cn/mmbiz/3Nsx3YNMeOv6rg4at4Txeak4b9Wkiaq9ib9tjFrJOGZQmfeAC4WapMdKMA7ZkfBLjicel4rwxdicOxhCHN3Z1y1rTQ/0?wx_fmt=jpeg', 'url' => 'http://mp.weixin.qq.com/s?__biz=MzAwNDU3NjAwMw==&mid=402303743&idx=1&sn=e9f6232ec4b8cf5e0b6faa8f89b28cbe#rd'
            ],
            2 => [
                'title' => '免费获取各种商品打折券，春节就要省省省。', 'des' => 'xxx', 'picurl' => 'https://mmbiz.qlogo.cn/mmbiz/3Nsx3YNMeOv6rg4at4Txeak4b9Wkiaq9ibuiamOrlB3usT9VuzibYFdAn0EFAANbic6C94U969Iy9oIqIUJa80N15cg/0?wx_fmt=jpeg', 'url' => 'http://mp.weixin.qq.com/s?__biz=MzAwNDU3NjAwMw==&mid=402303933&idx=1&sn=9f1b157a47d14c2dee8da2c14fc6abb4#rd'
            ]
        ];
        WechatCheck::_transmitArticleAndPic($object, $content);
    }

}

?>
