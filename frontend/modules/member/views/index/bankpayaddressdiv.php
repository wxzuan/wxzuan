<?php
$payAddress = \Yii::$app->cache->get("pay_address");
?>
<div id="qys_address_show" style="display: none;">
    <select name="province" class="qys_common_pay_provice contactField requiredField">
        <?php
        #获得所有省份列表
        #先从缓冲获得数据
        echo $payAddress['province_option'];
        #获得所有城市列表并按照省份排序
        #先从缓冲获得数据
        echo $payAddress['city_option'];
        ?>
</div>