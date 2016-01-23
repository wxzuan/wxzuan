<?php
namespace app\modules\wechat\services;
use common\models\User;
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
class WeixinKeyWordService {

    /**
     * 微信处理关键字
     */
    public static function fitKeyWord($obj, User $user) {
        $keyword = strtolower($obj->Content);
        switch ($keyword) {
            #开启图片保存
            case 'p':self::getPRepay($obj, $user);
                break;
            #关闭图片保存
            case 'ep':self::getEPRepay($obj, $user);
                break;
            default :self::getDefaultWorkRepay($obj, $user);
        }
    }

    /**
     * 
     * @return string
     */
    public static function getDefaultWorkRepay($object, $weixinuser) {
        $content = "亲爱的用户，您的留言我们已经收到,我们将尽快给你回复。";
        WechatCheck::_transmitText($object, $content);
    }

    /**
     * 
     * @return string
     */
    public static function getEPRepay($object, Users $weixinuser) {
        Yii::app()->cache->offsetUnset("qys_pic_save_" . $weixinuser->user_id);
        $content = "亲爱的用户，图片保存服务已关闭。";
        WechatCheck::_transmitText($object, $content);
    }

    /**
     * 
     * @return string
     */
    public static function getPRepay($object, Users $weixinuser) {
        $count = Pic::model()->count("user_id=:user_id", array(":user_id" => $weixinuser->user_id));
        if ($count < 20) {
            Yii::app()->cache->set("qys_pic_save_" . $weixinuser->user_id, $count);
            $content = "亲爱的用户，已经为你开启保存图片服务,当前已经保存了" . $count . "张,还能保存" . (20 - $count) . "张。";
        } else {
            $content = "亲爱的用户，您已经保存了20张图片,将不再给予保存。";
        }
        WechatCheck::_transmitText($object, $content);
    }

    //put your code here
    /**
     * 
     * @param type $data
     * @return string
     * 参数传入user用户实体,keyword关键字
     */
    public static function faFastBiao($data = array()) {
        $user = $data['user'];
        #没有绑定的帐号
        if (!$user) {
            return '没有绑定帐号,请先绑定帐号.';
        }
        #已经绑定的帐号
        $keyword = $data['keyword'];
        $fitkeyword = substr($keyword, 2);
        $thefitkeyword = strtolower($fitkeyword);
        $thefitkeyword = trim($thefitkeyword);
        $fastfabiaostatus = UserCache::model()->find("user_id=:user_id", array(":user_id" => $user->user_id));
        switch ($thefitkeyword) {
            case 'ed':
                #发标频率限制
                $timelimit = Yii::app()->cache->get("userfastfabiaolimit_" . $user->user_id);
                #$timelimit=false;
                if (!empty($timelimit)) {
                    return '查询过于频率,请在5秒钟后再次查询。';
                } else {
                    Yii::app()->cache->set("userfastfabiaolimit_" . $user->user_id, 1, 5);
                }
                $credits = FastSettingService::checkUserEd($user->user_id);
                $returnstring = "净值额度为：" . $credits['newworth'] . "\n";
                $returnstring.="信用额度为：" . $credits['credit_use'] . "\n";
                $returnstring.="大额股标额度为：" . $credits['stock_credit_use'] . "\n";
                return $returnstring;
                break;
            case 'k':
                if ($fastfabiaostatus->fabiao_status == 1) {
                    return '快速发标已经开启，请直接回复F#编号发布对应借款标.';
                } else {
                    $result = UserCache::model()->updateByPk($fastfabiaostatus->id, array("fabiao_status" => 1));
                    if ($result) {
                        #记录开启操作
                        $newfastsettinglog = new BorrowFastsettingLog();
                        $newfastsettinglog->setAttributes(array(
                            'user_id' => $fastfabiaostatus->user_id,
                            'borrow_setting_id' => 0,
                            'borrow_id' => 0,
                            'operate_status' => 4,
                            'remark' => '在微信端开启快速发标功能',
                            'content' => '开启发标功能',
                            'setting_end' => 2,
                            'addtime' => time(),
                            'addip' => Yii::app()->request->userHostAddress
                        ));
                        $newfastsettinglog->save();
                        return '快速发标已经开启，请直接回复F#编号发布对应借款标.';
                    } else {
                        return '功能开启出错,请联系客服。';
                    }
                }
                break;
            case 'g':
                if ($fastfabiaostatus->fabiao_status == 0) {
                    return '快速发标已经关闭。';
                }
                $result = UserCache::model()->updateByPk($fastfabiaostatus->id, array("fabiao_status" => 0));
                if ($result) {
                    #记录开启操作
                    $newfastsettinglog = new BorrowFastsettingLog();
                    $newfastsettinglog->setAttributes(array(
                        'user_id' => $fastfabiaostatus->user_id,
                        'borrow_setting_id' => 0,
                        'borrow_id' => 0,
                        'operate_status' => 5,
                        'remark' => '在微信端关闭快速发标功能',
                        'content' => '关闭发标功能',
                        'setting_end' => 2,
                        'addtime' => time(),
                        'addip' => Yii::app()->request->userHostAddress
                    ));
                    $newfastsettinglog->save();
                    return '快速发标功能已关闭。';
                } else {
                    return '快速功能关闭失败。';
                }
                break;
            default :
                #发标频率限制
                $timelimit = Yii::app()->cache->get("userfastfabiaolimit_" . $user->user_id);
                #$timelimit=false;
                if (!empty($timelimit)) {
                    return '发标过于频率,请在5秒钟后再次发标。';
                } else {
                    Yii::app()->cache->set("userfastfabiaolimit_" . $user->user_id, 1, 5);
                }
                $fastsetting = BorrowFastsetting::model()->find("user_id=:user_id and order_number=:order_number", array(':user_id' => $user->user_id, ':order_number' => $thefitkeyword));
                if ($fastsetting) {
                    $fabiaomsg = FastSettingService::faBiaoByFastSetting($user->user_id, $fastsetting->id, $thefitkeyword);
                    return $fabiaomsg['msg'];
                } else {
                    return '没有此命令或者发标编号,请确认操作。';
                }
                break;
        }
    }

    /**
     * 对D关键词的处理
     * @param type $user
     * @param type $object
     * @param type $keyword
     * @param type $weixinuser
     * @return string
     */
    public static function getDKeyword($user, $object, $keyword, $weixinuser) {
        $querydate = substr($keyword, 2);
        $start_time = strtotime($querydate);
        $curent_time = strtotime(date('Y-m'));
        if ($start_time) {
            $end_time = strtotime("+1 month", $start_time);
            $user = $weixinuser->getUser($object->FromUserName);
            if ($user) {

                $cache_qys_weixin_totalrepay = Yii::app()->cache->get("qys_weixinquery_Month_" . $start_time . $user->user_id);
                if (!$cache_qys_weixin_totalrepay) {
                    #1.当前月实时计算,把股票标标满付息单独计算 2.小于当月前查找dw_rep_profit_month
                    if ($start_time >= $curent_time) {
                        #当前月份
                        #信用标,净值标利息
                        $part_one_sql = "select sum(bc.interest) as sum_money
                                        from dw_borrow_collection as bc
                                        left join dw_borrow as b
                                        on bc.borrow_id=b.id
                                        where bc.user_id=:user_id
                                        and bc.status = 1 
                                        and b.is_vouch <> 5 
                                        and bc.repay_yestime >=:start_time
                                        and bc.repay_yestime <=:end_time ";
                        $part_one_interest = Yii::app()->db->createCommand($part_one_sql)->queryScalar(array(":user_id" => $user->user_id,
                            ":start_time" => $start_time,
                            ":end_time" => $end_time));
                        #股票标利息 股票标标满付息没有写collection　repay_yestime字段,用addtime来计算每个月的利息,因付息时才写collection记录
                        #addtime相当于付息时间
                        $part_two_sql = "select sum(bc.interest) as sum_money, bc.user_id
                                        from dw_borrow_collection as bc
                                        left join dw_borrow as b
                                        on bc.borrow_id=b.id
                                        where bc.user_id=:user_id
                                        and b.is_vouch = 5 
                                        and b.status = 3
                                        and bc.addtime >=:start_time
                                        and bc.addtime <=:end_time ";
                        $part_two_interest = Yii::app()->db->createCommand($part_two_sql)->queryScalar(array(":user_id" => $user->user_id,
                            ":start_time" => $start_time,
                            ":end_time" => $end_time));
                        $total_interest = $part_one_interest + $part_two_interest;
                    } elseif ($start_time < $curent_time) {
                        $start_month = date('m', $start_time);
                        $start_year = date('Y', $start_time);
                        $total_interest_sql = "select profit from dw_rep_profit_month " .
                                "where user_id=:user_id and year=:year and month =:month";
                        $total_interest = Yii::app()->db->createCommand($total_interest_sql)->queryScalar(array(":user_id" => $user->user_id,
                            ":year" => $start_year,
                            ":month" => $start_month));
                    }
                    Yii::app()->cache->set("qys_weixinquery_Month_" . $start_time . $user->user_id, $total_interest, 30);
                } else {
                    $total_interest = $cache_qys_weixin_totalrepay;
                }
                $content = $querydate . "月收益为：" . $total_interest;
            } else {
                $content = "您没有绑定好帮贷的帐号哦，请先绑定帐号吧!";
            }
        } else {
            $content = "回复指令有错,请回复D#日期,如D#2014-09";
        }
        return $content;
    }

    /**
     * 对D关键词的处理
     * @param type $user
     * @param type $object
     * @param type $keyword
     * @param type $weixinuser
     * @return string
     */
    public static function getUKeyword($user, $object, $keyword, $weixinuser) {
        $updateusername = substr($keyword, 2);
        #查询当前帐号是否已经被绑定
        $num = User::model()->count("username=:username AND status=1", array(":username" => $updateusername));
        if ($num > 0) {
            $content = "当前的帐号" . $updateusername . "已经绑定,不能再次绑定,如非本人绑定,请联系客服!";
        } elseif ($user) {
            $content = "已经关联帐号,请回复P#手机号获得验证码";
        } else {
            $result = User::model()->updateAll(array("wangwang" => $object->FromUserName), "username=:username", array(":username" => $updateusername));
            if ($result) {
                $content = "已经关联帐号,请回复P#手机号进行";
            } else {
                $content = "不存在该用户名";
            }
        }
        return $content;
    }

    /**
     * 对D关键词的处理
     * @param type $user
     * @param type $object
     * @param type $keyword
     * @param type $weixinuser
     * @return string
     */
    public static function getPKeyword($user, $object, $keyword, $weixinuser) {
        #验证手机号，并发送验证码
        if ($user && $user->status == 1) {
            $content = "您的帐号已经绑定,不需要再次绑定";
        } elseif ($user) {
            $updatepwd = substr($keyword, 2);
            #验证是否是该用户的手机号
            if ($user->phone === $updatepwd && $user->phone_status == 1) {
                #防止频繁发送验证码
                if ($user->repsativetime && time() < $user->repsativetime + 30) {
                    $content = "验证码发送过于频繁，每30秒允许发送一次。";
                } else {
                    $phoneyezhangma = rand(100000, 999999);
                    #发送验证信息
                    Yii::import("ext.sendSMS.BaseSendSMS");
                    $sms = new BaseSendSMS();
                    $sendata = array();
                    $sendata['user_id'] = array($user->user_id);
                    $sendata['phone'] = array($user->phone);
                    $sendata['msg'] = "验证码:" . $phoneyezhangma . "请在微信端回复进行帐号绑定，发送于" . date("Y-m-d H:i:s");
                    $sendata['type'] = "system";
                    $thisresult = $sms->commonsendSMS($sendata);
                    if ($thisresult != 1) {#发送失败
                        $content = "验证码发送失败，请重新回复。";
                    } else {#发送成功
                        #更改用户的
                        $result = User::model()->updateByPk($user->user_id, array("repstaken" => $phoneyezhangma, "repsativetime" => time() + 10 * 60));
                        $content = "验证码已发送,请在10分钟有效期内回复验证码。回复格式Y#256487";
                    }
                }
            } else {
                $content = "手机号不匹配关联用户名。或者没有通过手机验证";
            }
        } else {
            $content = "你的帐号还没有进行关联，不能进行绑定，请先进行关联";
        }
        return $content;
    }

    /**
     * 对D关键词的处理
     * @param type $user
     * @param type $object
     * @param type $keyword
     * @param type $weixinuser
     * @return string
     */
    public static function getYYKeyword($user, $object, $keyword, $weixinuser) {
        #获得提现验证码
        $user = $weixinuser->getUser($object->FromUserName);
        if ($user) {
            $cache_qys_weixin_tixian = Yii::app()->cache->get("qys_weixinquery_tixian_" . $user->user_id);
            if (!$cache_qys_weixin_tixian) {
                $repaytotal = UserSendesmsLog::model()->find("type='tianxian' AND phone=:phone AND addtime>=(UNIX_TIMESTAMP()-600) order by id desc", array(":phone" => $user->phone));
                if ($repaytotal) {
                    $msg = $repaytotal->msg . "(数据10秒钟刷新一次.请勿频繁查询.)";
                } else {
                    $msg = "暂时没有提现验证码数据,如果你刚刚发送,请在10秒钟后再进行查询.";
                }
                Yii::app()->cache->set("qys_weixinquery_tixian_" . $user->user_id, $msg, 10);
            } else {
                $msg = $cache_qys_weixin_tixian;
            }
            $content = $msg;
        } else {
            $content = "您没有绑定好帮贷的帐号哦，请先绑定帐号吧!";
        }
        return $content;
    }

    /**
     * 对D关键词的处理
     * @param type $user
     * @param type $object
     * @param type $keyword
     * @param type $weixinuser
     * @return string
     */
    public static function getYKeyword($user, $object, $keyword, $weixinuser) {
        #验证手机号，并发送验证码
        if ($user && $user->status == 1) {
            $content = "您的帐号已经绑定";
        } elseif ($user) {
            $updatepwd = substr($keyword, 2);
            #验证是否是该用户的手机号
            if ($user->repstaken === $updatepwd && time() <= $user->repsativetime + 10 * 60) {
                $result = User::model()->updateByPk($user->user_id, array("status" => 1));
                if ($result) {
                    $content = "微信绑定成功";
                } else {
                    $content = "微信绑定失败";
                }
            } else {
                $content = "验证码不正确,如果您没有接收成功，请回帮P#手机号获得验证码";
            }
        } else {
            $content = "你的帐号还没有进行关联，不能进行绑定，请先进行关联";
        }
        return $content;
    }

}

?>
