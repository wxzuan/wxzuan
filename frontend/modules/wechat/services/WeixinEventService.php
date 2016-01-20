<?php

namespace app\modules\wechat\services;

use common\models\User;
use app\modules\wechat\components\WechatCheck;
use app\modules\wechat\services\ClickService;
use common\models\Logistics;
use PDO;
use yii\helpers\Html;

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
            #关注处理
            case 'unsubscribe':
                self::fitSubscribe($object, $weixinuser);
                break;
            #扫码处理数据
            case 'scancode_waitmsg':
                self::fitScancode_waitmsg($object, $weixinuser);
                break;
            default :
                $repaydata = self::getDefaultClick($object, $weixinuser);
                break;
        }
    }

    /**
     * 处理扫码内容
     * @param type $object
     * @param User $weixinuser
     */
    public static function fitScancode_waitmsg($object, User $weixinuser) {
        $scanType = $object->ScanCodeInfo->ScanType;
        $content = " 扫描结果：" . $object->ScanCodeInfo->ScanResult;
        if ($scanType == 'qrcode') {
            $string = $object->ScanCodeInfo->ScanResult;
            #解码
            #获得ID
            $data = explode(",", $string);
            if (is_numeric($data[0]) && isset($data[1]) && !empty($data[1])) {
                #获得货物数据
                $logis_id = $data[0];
                $token = urldecode($data[1]);
                //判断这个ID是否已经被处理过了
                $logs = Logistics::findOne($logis_id);
                if (!$logs || $logs->bail_lock != 0) {
                    $content = '该信息不存在或者已经被接单。';
                } else {
                    //解密数据
                    $jsonstring = \Yii::$app->security->decryptByKey($token, $logs->hash_key);
                    $fitdata = json_decode($jsonstring);
                    if ($fitdata->tokenstring != $logs->hash_key) {
                        $content = '密钥对应不上，不能进行操作。';
                    } else {
                        $user_id = $weixinuser->user_id;
                        try {
                            $addip = '0.0.0.0';
                            $conn = \Yii::$app->db;
                            $command = $conn->createCommand('call p_lock_logis_Bail(:in_user_id,:logis_id,:in_addip,@out_status,@out_remark)');
                            $command->bindParam(":in_user_id", $user_id, PDO::PARAM_INT);
                            $command->bindParam(":logis_id", $logis_id, PDO::PARAM_INT);
                            $command->bindParam(":in_addip", $addip, PDO::PARAM_STR, 50);
                            $command->execute();
                            $result = $conn->createCommand("select @out_status as status,@out_remark as remark")->queryOne();
                        } catch (Exception $e) {
                            $result = ['status' => 0, 'remark' => '系统繁忙，暂时无法处理'];
                        }
                        $content = $result['remark'];
                        if ($result['status'] == 1) {
                            $content = '担保！【 ' . Html::encode($logs->logis_name) . ' 】成功,冻结担保金【 ' . $logs->logis_bail . ' 】元,完成送货可获得佣金【 ' . $logs->logis_fee . ' 】元';
                        }
                    }
                }
            }
        }
        WechatCheck::_transmitText($object, $content);
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
