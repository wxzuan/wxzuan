<?php

namespace app\modules\wechat\components;

use common\models\User;
use common\models\Account;
use app\modules\wechat\services\WeixinKeyWordService;
use app\modules\wechat\services\WeixinClickService;
use app\modules\wechat\services\WeixinImageService;
use app\modules\wechat\services\WeixinLinkService;
use app\modules\wechat\services\WeixinLocationService;
use app\modules\wechat\services\WeixinVideoService;
use app\modules\wechat\services\WeixinVoiceService;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
  '{
  "button":[
  {
  "type":"view",
  "name":"注册",
  "url":"http://www.hao8dai.com/wechat/public/register.html"
  },
  {
  "type":"view",
  "name":"投资",
  "url":"http://www.hao8dai.com/wechat/default/invest.html"
  },
  {

  "name":"查询",
  "sub_button":[
  {
  "type":"click",
  "name":"我的余额",
  "key":"weixin_usemoney"
  },
  {
  "type":"click",
  "name":"今日待还",
  "key":"weixin_totalrepay"
  },
  {
  "type":"click",
  "name":"今日待收",
  "key":"weixin_totalcollection"
  },
  {
  "type":"click",
  "name":"更多功能",
  "key":"weixin_command"
  },
  {
  "type":"click",
  "name":"绑定帐号",
  "key":"weixin_bind"
  }]
  }
  ]
  }';
 */
use yii\base\Component;

/**
 * Description of WechatCheck
 *
 * @author qinyangsheng
 */
class WechatCheck extends Component {

    //put your code here
//
//    const token = 'zuanzuanle5130';

    public $APPID;
    public $APPSECRET;

//
//    //基本接口地址

    const BASE_WEIXIN_URL = "https://api.weixin.qq.com";
//    //申请access_token的地址
    const TOKEN_URL = "/cgi-bin/token?grant_type=client_credential";
//    //获得菜单信息地址
    const GET_MENU_URL = "/cgi-bin/menu/get?access_token=";
//    //创建菜单信息地址
    const CREATE_MENU_URL = "/cgi-bin/menu/create?access_token=";
//    //删除菜单信息地址
    const DELETE_MENU_URL = "/cgi-bin/menu/delete?access_token=";

//    static $WEIXIN_MENU = '{"button":[{"type":"view","name":"注册","url":"http://www.hao8dai.com/wechat/public/register.html"}]}';
//    //菜单设置
    static $WEIXIN_MENU = array(
        'button' => array(
            array("type" => 'click', "name" => "获取权限", "key" => "weixin_userlogin"),
            array(
                'name' => '占卜',
                'sub_button' => array(
                    array("type" => 'click', "name" => "用力点", "key" => "weixin_clickone"),
                    array("type" => 'click', "name" => "不要点", "key" => "weixin_clicktwo"),
                    array("type" => 'click', "name" => "随便点", "key" => "weixin_clickthree")
                )
            ),
            array(
                'name' => '查询',
                'sub_button' => array(
                    array("type" => 'click', "name" => "我的资金", "key" => "weixin_usemoney"),
                    array("type" => 'click', "name" => "快速分享", "key" => "weixin_sharp"),
                    array("type" => 'view', "name" => "代理推广", "url" => "http://www.zuanzuanle.com/wechat/help/daili.html"),
                )
            )
        )
    );
    //保存类实例的静态成员变量
    private static $_instance;
//标识串
    private $access_token = null;
//标识串无效时间
    private $access_token_endtime = null;
    public $user = null;

    public function _valid() {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

//
    private function checkSignature() {
        // you must define TOKEN by yourself

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = self::token;
        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

//private标记的构造方法
    function __construct() {
        $this->checkAccessToken();
    }

//
//
    /**
     * 检查access_token是否起作用
     */
    public function checkAccessToken() {

        if ($this->access_token_endtime === null || $this->access_token_endtime < time()) {
//            重新申请access_token
            $json = file_get_contents(WechatCheck::BASE_WEIXIN_URL . WechatCheck::TOKEN_URL . "&appid=" . $this->APPID . "&secret=" . $this->APPSECRET);
            if ($json) {
                $result = json_decode($json, true);
                if (isset($result['access_token'])) {
                    $this->access_token = $result['access_token'];
                    $this->access_token_endtime = time() + $result['expires_in'];
                } else {
                    echo 'errormsg';
                }
            }
        }
    }

//    /**
//     * 获得自定义菜单
//     */
    public function getMenu() {
        $MENU_URL = WechatCheck::BASE_WEIXIN_URL . WechatCheck::GET_MENU_URL . $this->access_token;
        $menu = $this->getUrlResult($MENU_URL);
        $menulist = (array) json_decode($menu);
        #如果没有菜单，创建菜单
        if (empty($menulist->menu->button)) {
            return false;
        } else {
            return true;
        }
    }

//
//    /**
//     * 创建自定义菜单
//     */
    public function createMenu() {
        $MENU_URL = WechatCheck::BASE_WEIXIN_URL . WechatCheck::CREATE_MENU_URL . $this->access_token;

        $this->getPostResult($MENU_URL);
    }

//
//    /**
//     * 获得自定义菜单
//     */
    public function deleteMenu() {
        $MENU_URL = WechatCheck::BASE_WEIXIN_URL . WechatCheck::DELETE_MENU_URL . $this->access_token;
        $menu = $this->getUrlResult($MENU_URL);
        $menulist = (array) json_decode($menu);
        #如果没有菜单，创建菜单
        if ($menulist['errcode'] == 0) {
            return true;
        } else {
            return false;
        }
    }

//
//    /**
//     * 获得请求url后得到的参数
//     */
    public function getUrlResult($str = "") {
        $cu = curl_init();
        curl_setopt($cu, CURLOPT_URL, $str);
        curl_setopt($cu, CURLOPT_RETURNTRANSFER, 1);
        $menu_json = curl_exec($cu);
        curl_close($cu);
        return $menu_json;
    }

//
//    /**
//     * 获得提交请求后得到的参数
//     */
    public function getPostResult($str = "") {
        $ch = curl_init();
        //echo $str;exit;
        curl_setopt($ch, CURLOPT_URL, $str);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        $json_string = (json_encode(WechatCheck::$WEIXIN_MENU, JSON_UNESCAPED_UNICODE));
        $json_string = str_replace('\\', '', $json_string);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $info = curl_exec($ch);
        if (curl_errno($ch)) {
            return false;
        }

        curl_close($ch);
        $message = json_decode($info);
        return $message->errcode;
    }

//
////消息处理
////仅实现了文本消息和推送事件
    public function _responseMsg() {
        $postStr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : "";
        if (!empty($postStr)) {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);


            $RX_TYPE = trim($postObj->MsgType);

            #判断是否用户已经登录
            $user = self::addOrLoginUser($postObj->FromUserName);
            if ($user === 3) {
                $content = "您没有成为本平台成员，不能做这个操作。";
                self::_transmitText($postObj, $content);
            }
            switch ($RX_TYPE) {
                case "text":
                    $resultStr = WeixinKeyWordService::fitKeyWord($postObj, $user);
                    break;
                case "image":
                    $resultStr = WeixinImageService::fitImage($postObj, $user);
                    break;
                case "location":
                    $resultStr = WeixinLocationService::fitLocation($postObj);
                    break;
                case "voice":
                    $resultStr = WeixinVoiceService::fitVoice($postObj);
                    break;
                case "video":
                    $resultStr = WeixinVideoService::fitVideo($postObj);
                    break;
                case "link":
                    $resultStr = WeixinLinkService::fitLink($postObj);
                    break;
                case "event":
                    $resultStr = WeixinClickService::fitEvent($postObj, $user);
                    break;
                default:
                    $resultStr = "unknow msg type: " . $RX_TYPE;
                    break;
            }
            if (!empty($resultStr)) {
                echo $resultStr;
            }
        } else {
            echo "";
        }
    }

//
//    /**
//     * 当微信接收到文本信息时候的处理
//     * @param Object $postObj 微信post传递过来的XML对象
//     * @return XML 微信XML
//     */
//    private function _receiveText($object) {
////p($object);
//        $user = $this->user;
//        $keyword = (string) $object->Content;
//#得到第二个字符
//        $stringlength = strlen(trim($keyword));
//        $havereply = false;
//        if ("yy" === strtolower(trim($keyword))) {
//            $havereply = true;
//        } elseif ($stringlength > 5) {
//            $keystring = substr($keyword, 1, 1);
//            if ($keystring === "#") {
//                $havereply = true;
//            }
//        }
//        if ($keyword == '0') {
//            $repaydata = WeixinClickService::getMoreComandClick();
//            $content = $repaydata['content']['msg'];
//            echo $this->_transmitText($object, $content);
//            return;
//        }
//#如果有关键字，调用关键字回复
//        if ($havereply) {
//            $content = $this->weixinsend->getKeyWordRep($user, $object, $keyword, $this->weixinuser);
//        } else {
//            $content = "您好！尊敬的用户，无法识别你的命令!回复0获得对应指令回复!";
//        }
//        echo $this->_transmitText($object, $content);
//    }
//
//    /**
//     * 当微信接收到事件时候的处理
//     * @param Object $postObj 微信post传递过来的XML对象
//     * @return XML 微信XML
//     */
//    private function _receiveEvent($object) {
//        $repaydata['content'] = array('msg' => "");
//        $reptype = "text";
//        switch ($object->Event) {
//            case "VIEW":
//                $repaydata['content'] = array('msg' => "");
//                break;
//            case "subscribe":
//                $repaydata = $this->weixinsend->getSubscribeEventRepose($object, $this->weixinuser);
//                $reptype = $repaydata['type'];
//                break;
//            case "unsubscribe":
//                $repaydata['content'] = array('msg' => "");
//                break;
//            case "CLICK":
//                $repaydata = $this->weixinsend->getClickEventRepose($object, $this->weixinuser);
//                $reptype = $repaydata['type'];
//                break;
//            case "LOCATION":
//                $repaydata['content'] = array('msg' => "");
//                break;
//            default:
//                $repaydata['content'] = array('msg' => "receive a new event: " . $object->Event());
//                break;
//        }
//        $resultStr = $this->_transmitRep($object, $repaydata, $reptype);
//
//        echo $resultStr;
//    }
//
//    /**
//     * 当微信接收到图片时候的处理
//     * @param Object $postObj 微信post传递过来的XML对象
//     * @return XML 微信XML
//     */
//    private function _receiveImage($postObj) {
//        return TRUE;
//    }
//
//    /**
//     * 当微信接收到位置时候的处理
//     * @param Object $postObj 微信post传递过来的XML对象
//     * @return XML 微信XML
//     */
//    private function _receiveLocation($postObj) {
//        return TRUE;
//    }
//
//    /**
//     * 当微信接收到语音时候的处理
//     * @param Object $postObj 微信post传递过来的XML对象
//     * @return XML 微信XML
//     */
//    private function _receiveVoice($postObj) {
//        echo $this->_transmitText($postObj, $postObj->Recognition);
//    }
//
//    /**
//     * 当微信接收到视频时候的处理
//     * @param Object $postObj 微信post传递过来的XML对象
//     * @return XML 微信XML
//     */
//    private function _receiveVideo($postObj) {
//        return TRUE;
//    }
//
//    /**
//     * 当微信接收到连接时候的处理
//     * @param Object $postObj 微信post传递过来的XML对象
//     * @return XML 微信XML
//     */
//    private function _receiveLink($postObj) {
//        return TRUE;
//    }
//
//    /**
//     * 把图文转成微信可以回复给微信的XML
//     * @param object $object 微信pos通过了的xml对象
//     * @param string $content 要返回给微信的文字内容
//     * @param type $flag 微信信息标记 TODO还没有搞清楚怎么使用
//     * @return XML
//     */
    public static function _transmitArticleAndPic($object, $repaydata) {
        #绑定头部
        $textheaderTpl = WechatTemplate::getArtitlePic_T("0");
        $resultStr = sprintf($textheaderTpl, $object->FromUserName, $object->ToUserName, time(), count($repaydata['content']));
        #绑定内容
        $textbodyTpl = WechatTemplate::getArtitlePic_T("1");
        $key = 1;
        foreach ($repaydata['content'] as $reponevalue) {
            if ($key > 10) {
                break;
            }
            $resultStr.=sprintf($textbodyTpl, $reponevalue['title'], $reponevalue['des'], $reponevalue['picurl'], $reponevalue['url']);
            $key++;
        }
        #绑定脚部
        $textfooterTpl = WechatTemplate::getArtitlePic_T("2");
        $resultStr.=sprintf($textfooterTpl, 0);
        $textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[%s]]></Content><MsgId>%d</MsgId></xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $resultStr, $object->MsgId);
        echo $resultStr;
        Yii::app()->end();
    }

//    /**
//     * 把文字转成微信可以回复给微信的XML
//     * @param object $object 微信pos通过了的xml对象
//     * @param string $content 要返回给微信的文字内容
//     * @param type $flag 微信信息标记 TODO还没有搞清楚怎么使用
//     * @return XML
//     */
    public static function _transmitText($object, $content) {
        $textTpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[%s]]></Content><MsgId>%d</MsgId></xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $object->MsgId);
        echo $resultStr;
        Yii::app()->end();
    }

//
//    /**
//     * 对关注者进行对应的回复处理
//     * @param object $object 微信pos通过了的xml对象
//     * @param array $repaydata 要返回给微信的文字内容
//     * @param string $type 回复类型
//     * @param type $flag 微信信息标记
//     * @return XML
//     */
//    private function _transmitRep($object, $repaydata, $type) {
//        switch ($type) {
//            case 'text':$textTpl = Wechat::getTextRep();
//                $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $repaydata['content']['msg'], $object->MsgId);
//                break;
//            case 'news':
//                #绑定头部
//                $textheaderTpl = Wechat::getNewsRep("0");
//                $resultStr = sprintf($textheaderTpl, $object->FromUserName, $object->ToUserName, time(), count($repaydata['content']));
//                #绑定内容
//                $textbodyTpl = Wechat::getNewsRep("1");
//                $key = 1;
//                foreach ($repaydata['content'] as $reponevalue) {
//                    if ($key > 10) {
//                        break;
//                    }
//                    $resultStr.=sprintf($textbodyTpl, $reponevalue['title'], $reponevalue['des'], $reponevalue['picurl'], $reponevalue['url']);
//                    $key++;
//                }
//                #绑定脚部
//                $textfooterTpl = Wechat::getNewsRep("2");
//                $resultStr.=sprintf($textfooterTpl, 0);
//                break;
//            default :$textTpl = Wechat::getTextRep();
//                $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $repaydata['content']['msg'], $object->MsgId);
//        }
//        return $resultStr;
//    }
    public static function addOrLoginUser($weixinUser) {
        #返回串功能
        $returnstring = 3;
        $user = User::find()->where("wangwang=:weixin_open_id", [":weixin_open_id" => $weixinUser])->one();
        if (!$user) {
            $user = self::addUser($weixinUser);
        }
        #如果存在或者注册成功那么直接进行登录
        if ($user) {
            return $user;
        } else {
            #没有注册成功
            return 3;
        }
    }

    public static function addUser($weixinUser) {
        #注册新用户
        $newuser = new User();
        $newuser->setAttribute('username', $weixinUser);
        $newuser->setAttribute('password', 'ooxxooxx');
        $newuser->setAttribute('wangwang', $weixinUser);
        $newuser->setAttribute('privacy', uniqid());
        if ($newuser->validate() && $newuser->save()) {

            $accountarray = array(
                'user_id' => \Yii::$app->db->getLastInsertID(),
                'total' => 0,
                'use_money' => 0,
                'no_use_money' => 0,
                'newworth' => 0,
            );
            $newAccount = new Account();
            $newAccount->setAttributes($accountarray);
            $newAccount->save();
        }
        $user = User::find()->where("username=:username", [":username" => $weixinUser])->one();
        return $user;
    }

    public static function addLog($content) {
        $filePath = "/var/www/html/wxzuan/frontend/runtime/logs/log.txt";

        $time = date("Y-m-d H.i.s", time());
        $string = $time . "\n" . $content . "\n";
        $fp = fopen($filePath, "a");
        if (fwrite($fp, $string)) {
            return true;
        } else {
            fclose($fp);
            return FALSE;
        }
    }

}
