<?php

namespace common\services;

use common\models\Province;
use common\models\City;
use common\models\Area;
use common\models\Payarea;
use Yii;

class BaseInitService {

    /**
     * 初始化与系统地址有关的文件缓冲
     */
    public static function initSysaddress() {
        $sysaddress = array();
        //配置ID与地区匹配缓冲
        $province = Province::find()->where('1=1')->orderBy('id asc')->all();
        $city = City::find()->where('1=1')->orderBy('father asc,id asc')->all();
        $area = Area::find()->where('1=1')->orderBy('father asc,id asc')->all();
        foreach ($province as $value) {
            $sysaddress['province'][$value->provinceID] = $value->province;
        }
        foreach ($city as $value) {
            $sysaddress['city'][$value->cityID] = $value->city;
        }
        foreach ($area as $value) {
            $sysaddress['area'][$value->areaID] = $value->area;
        }


        //配置多级联动操作相关缓冲
        $sysaddress['province_option'] = '';
        foreach ($province as $value) {
            $sysaddress['province_option'].= '<option value="' . $value->provinceID . '">' . $value->province . '</option>';
        }
        $sysaddress['province_option'] = '<select name="province" class="qys_common_provice contactField requiredField">' . $sysaddress['province_option'] . '</select>';

        #获得所有城市列表并按照省份排序
        #先从缓冲获得数据
        $i = 0;
        $city_list_fit = '';
        foreach ($city as $value) {
            if ($value->father !== $i) {
                $city_list_fit.='</select><select name="city" class="qys_common_city_' . $value->father . ' contactField requiredField">';
                $i = $value->father;
            }
            $city_list_fit.='<option value="' . $value->cityID . '">' . $value->city . '</option>';
        }
        $city_list_fit.='</select>';
        $city_list_fit = substr($city_list_fit, 9);
        $sysaddress['city_option'] = $city_list_fit;

        #获得所有城市列表并按照省份排序
        #先从缓冲获得数据
        $i = 0;
        $area_list_fit = '';
        foreach ($area as $value) {
            if ($value->father !== $i) {
                $area_list_fit.='</select><select name="area" class="qys_common_area_' . $value->father . ' contactField requiredField">';
                $i = $value->father;
            }
            $area_list_fit.='<option value="' . $value->areaID . '">' . $value->area . '</option>';
        }
        $area_list_fit.='</select>';
        $area_list_fit = substr($area_list_fit, 9);
        $sysaddress['area_option'] = $area_list_fit;
        \Yii::$app->cache->set('sys_address', $sysaddress);
    }

    /**
     * 初始化支付地区相关文件缓冲
     */
    public static function initPayaddress() {
        $payaddress = array();
        #获得所有省份列表
        #先从缓冲获得数据
        $provice_list = Payarea::find()->where("pid=0")->orderBy("id asc")->All();
        $payaddress['province_option'] = '';
        foreach ($provice_list as $value) {
            $payaddress['province_option'].= '<option value="' . $value->p_code . '">' . $value->name . '</option>';
        }
        $payaddress['province_option'] = '<select name="province" class="qys_common_pay_provice contactField requiredField">' . $payaddress['province_option'] . '</select>';


        #获得所有城市列表并按照省份排序
        #先从缓冲获得数据

        $city_list = Payarea::find()->where("pid<>0")->orderBy(" pid asc,id asc ")->All();
        $i = 0;
        $city_list_fit = '';
        foreach ($city_list as $value) {
            if ($value->p_code !== $i) {
                $city_list_fit.='</select><select name="city" class="qys_common_pay_city_' . $value->p_code . ' contactField requiredField">';
                $i = $value->p_code;
            }
            $city_list_fit.='<option value="' . $value->a_code . '">' . $value->name . '</option>';
        }
        $city_list_fit.='</select>';
        $city_list_fit = substr($city_list_fit, 9);

        $payaddress['city_option'] = $city_list_fit;
        \Yii::$app->cache->set('pay_address', $payaddress);
    }

}
