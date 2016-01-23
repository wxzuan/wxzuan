<?php

namespace common\services;

use common\models\Province;
use common\models\City;
use common\models\Area;
use Yii;

class CacheService {

    /**
     * 获得省份名称
     * @return string
     */
    public static function getProvinceNameById($id) {
        $provinceLists = \Yii::$app->cache->get('cache_province');
        if (!$provinceLists) {
            $province = Province::find()->where('1=1')->orderBy('id asc')->all();
            foreach ($province as $onePr) {
                $provinceLists[$onePr->provinceID] = $onePr->province;
            }
            \Yii::$app->cache->set('cache_province', $provinceLists);
        }

        return $provinceLists[$id];
    }

    /**
     * 获得城市名称
     * @return string
     */
    public static function getCityNameById($id) {
        $cityLists = \Yii::$app->cache->get('cache_city');
        if (!$cityLists) {
            $city = City::find()->where('1=1')->orderBy('id asc')->all();
            foreach ($city as $one) {
                $cityLists[$one->cityID] = $one->city;
            }
            \Yii::$app->cache->set('cache_city', $cityLists);
        }

        return $cityLists[$id];
    }

    /**
     * 获得地区名称
     * @return string
     */
    public static function getAreaNameById($id) {
        $areaLists = \Yii::$app->cache->get('cache_area');
        if (!$areaLists) {
            $area = Area::find()->where('1=1')->orderBy('id asc')->all();
            foreach ($area as $one) {
                $areaLists[$one->areaID] = $one->area;
            }
            \Yii::$app->cache->set('cache_area', $areaLists);
        }

        return $areaLists[$id];
    }

}
