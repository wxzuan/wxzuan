<?php
namespace app\modules\wechat\components;
/**
 * Description of WechatCheck
 *
 * @author qinyangsheng
 */
class WechatTemplate {

    /**
     * 获得图文模板
     * @param type $string
     * @return string
     */
    public static function getArtitlePic_T($string = "0") {
        switch ($string) {
            case "0":$tpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[news]]></MsgType><ArticleCount>%s</ArticleCount><Articles>";
                break;
            case "1":$tpl = "<item><Title><![CDATA[%s]]></Title><Description><![CDATA[%s]]></Description><PicUrl><![CDATA[%s]]></PicUrl><Url><![CDATA[%s]]></Url></item>";
                break;
            case "2":$tpl = "</Articles></xml>";
                break;
            default:$tpl = "<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%s</CreateTime><MsgType><![CDATA[news]]></MsgType><ArticleCount>%s</ArticleCount><Articles>";
        }
        return $tpl;
    }

}
