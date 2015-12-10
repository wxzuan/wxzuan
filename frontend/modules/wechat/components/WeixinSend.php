<?php
namespace app\modules\wechat\components;
//---------------------------------Wechat----------------------------------------
class WeixinSend {

    private static $weixinsend;

    /**
     * 
     * @return type
     * 获得一个发送信息的单例
     */
    public static function getInstance() {
        if (self::$weixinsend) {
            return self::$weixinsend;
        } else {
            self::$weixinsend = new WeixinSend();
            return self::$weixinsend;
        }
    }

    /**
     * 获得关键字回复
     */
    public function getKeyWordRep($user, $object, $keyword, $weixinuser) {
        $firstkeyword = substr($keyword, 0, 1);
        if ("yy" === strtolower(trim($keyword))) {
            $firstkeyword = "yy";
        }
        $upfirstkeyword = strtoupper($firstkeyword);
        switch ($upfirstkeyword) {
            case 'D':
                $content = WeixinKeyWordService::getDKeyword($user, $object, $keyword, $weixinuser);
                break;
            case 'U':
                $content = WeixinKeyWordService::getUKeyword($user, $object, $keyword, $weixinuser);
                break;
            case 'P':
                $content = WeixinKeyWordService::getPKeyword($user, $object, $keyword, $weixinuser);
                break;
            case 'YY':
                $content = WeixinKeyWordService::getYYKeyword($user, $object, $keyword, $weixinuser);
                break;
            case 'Y':
                $content = WeixinKeyWordService::getYKeyword($user, $object, $keyword, $weixinuser);
                break;
            case 'F':
                $data = array('user' => $user, 'keyword' => $keyword);
                $content = WeixinKeyWordService::faFastBiao($data);
                break;
            default :
                $content = "您的回复参数不正确!\n1.回复D#2014-10得到月对帐单;\n2.回复U#username关联好帮贷用户名\n3.回复P#手机号获得验证码进行绑定操作";
                break;
        }
        return $content;
    }

    /**
     * 关注的时候给用户发欢迎信息
     */
    public function getSubscribeEventRepose() {
        $repaydata = array();
        $repaydata['content'][0] = array(
            'title' => '欢迎关注好帮贷，好帮贷-您的理财好帮手',
            'des' => '当前P2P网络金融盛行，选择那一个平台理财呢。好帮贷绝对值得你选择。',
            'picurl' => 'https://mmbiz.qlogo.cn/mmbiz/C6UcZFsAnsSS6ty5TCnstLJSY2QU1XkMHYA8VIalGWyra3DIPNOqTV9TmGQzxUdjKSsZaIjibHptPXDq2LfX4lA/0',
            'url' => 'http://mp.weixin.qq.com/s?__biz=MjM5NjY2NjQ3Mg==&mid=202448798&idx=1&sn=b12d9c17f45ea7e4fcc9f2a5f0d9f217#rd',
        );
        $repaydata['type'] = 'news';
        return $repaydata;
    }

    /**
     * 
     * @param type $obj
     * 处理菜单点事件
     */
    public function getClickEventRepose($object, $weixinuser) {
        switch ($object->EventKey) {
            #更多功能
            case 'weixin_command':
                $repaydata = WeixinClickService::getMoreComandClick();
                break;
            #可用金额
            case 'weixin_usemoney':
                $repaydata = WeixinClickService::getAccountClick($object, $weixinuser);
                break;
            #今日待还
            case 'weixin_totalrepay':
                $repaydata = WeixinClickService::getTodayRepayTotalClick($object, $weixinuser);
                break;
            #今日待收
            case 'weixin_totalcollection':
                $repaydata = WeixinClickService::getTodayCollectionTotalClick($object, $weixinuser);
                break;
            case 'weixin_bind':
                $repaydata = WeixinClickService::getBindClick($object, $weixinuser);
                break;
            default :
                $repaydata = WeixinClickService::getDefaultClick();
                break;
        }
        return $repaydata;
    }

}