<?php

use common\models\Province;
use common\models\City;
use common\models\Area;

$sysAddress = \Yii::$app->cache->get("sys_address");
?>
<div id="qys_address_show" style="display: none;">
    <?php
    #获得所有省份列表
    #先从缓冲获得数据
    echo $sysAddress['province_option'];
    #获得所有城市列表并按照省份排序
    #先从缓冲获得数据
    echo $sysAddress['city_option'];
    #获得所有城市列表并按照省份排序
    #先从缓冲获得数据
    echo $sysAddress['area_option'];
    ?>
</div>