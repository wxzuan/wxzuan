<?php
namespace common\controllers;
use common\services\BaseInitService;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of newPHPClass
 *
 * @author qinyangsheng
 */
class BaseController extends \yii\web\Controller {
    //put your code here
    function init() {
        parent::init();
        //初始化系统地址
        $sysaddress = \Yii::$app->cache->get('sys_address');
        if(!$sysaddress){
            BaseInitService::initSysaddress();
        }
        //初始化支付地区
        $payaddress = \Yii::$app->cache->get('pay_address');
        if(!$payaddress){
            BaseInitService::initPayaddress();
        }
    }

}
