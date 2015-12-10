<?php

namespace app\modules\wechat\controllers;

use yii\web\Controller;
use app\modules\wechat\components\WechatCheck;

class DefaultController extends Controller {

    /**
     *  初始化用户自定义菜单
     */
    function init() {
        //获得是否已经设定了自定义菜单
        $this->wechat = WechatCheck::getInstance();
//        $this->wechat->deleteMenu();
        if (!$this->wechat->getMenu()) {
            $this->wechat->createMenu();
        }
        parent::init();
    }

//微信来源验证
    public function actionIndex() {
        //接口校验
        if (isset($_GET['echostr'])) {
            $this->wechat->_valid();
        } else {
            WechatCheck::_responseMsg();
        }
        \Yii::$app->end();
    }

}
