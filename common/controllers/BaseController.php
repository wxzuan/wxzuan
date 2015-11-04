<?php
namespace common\controllers;
use common\models\Province;
use common\models\City;
use common\models\Area;
use Yii;
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
        $sysaddress = \Yii::$app->cache->get('sys_address');
        if(!$sysaddress){
            $this->initSysaddress();
        }
    }
    function initSysaddress(){
        $sysaddress=array();
        $province= Province::find()->where('1=1')->all();
        foreach ($province as $value) {
           $sysaddress['province'][$value->provinceID]=$value->province; 
        }
        $city= City::find()->where('1=1')->all();
        foreach ($city as $value) {
           $sysaddress['city'][$value->cityID]=$value->city; 
        }
        $area= Area::find()->where('1=1')->all();
        foreach ($area as $value) {
           $sysaddress['area'][$value->areaID]=$value->area; 
        }
        \Yii::$app->cache->set('sys_address', $sysaddress);
    }
}
