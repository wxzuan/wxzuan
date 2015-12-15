<?php

namespace app\modules\wechat\controllers;

use yii\web\Controller;

class ApiController extends Controller {

    public $enableCsrfValidation = false;

    /**
     *  初始化用户自定义菜单
     */
    function init() {
        //获得是否已经设定了自定义菜单
        if (isset($_GET['echostr'])) {
            \Yii::$app->wechat->_valid();
        } else {
            \Yii::$app->wechat->checkAccessToken();
            
            //\Yii::$app->wechat->deleteMenu();
            if (\Yii::$app->wechat->getMenu()) {
                \Yii::$app->wechat->createMenu();
            }
        }
        parent::init();
    }

//微信来源验证
    public function actionIndex() {
        //接口校验
        if (isset($_GET['echostr'])) {
            \Yii::$app->wechat->_valid();
        } else {
            \Yii::$app->wechat->_responseMsg();
        }
        \Yii::$app->end();
    }

}
