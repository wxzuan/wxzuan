<?php
/* @var $this yii\web\View */
$this->title = '会员中心';

use frontend\services\ProductService;
use app\models\Product;
use yii\helpers\Url;
?>
<div class="container no-bottom" style="background-color: #fae0ca;">              
    <p class="p_member_t">
        可用资金（元）    
    </p>
    <p class="p_member_m">
        100.00    
    </p>
    <div class="one-half">
        <p class="qys_member_center">
            今日收益<br>
            0.00
        </p>
    </div>
    <div class="two-half last-column">
        <p class="qys_member_center">
            总收益<br>
            100.00元 
        </p>        
    </div>
</div>
<div class="container no-bottom">
    <a href="<?= Url::toRoute('/product/index') ?>"  style="width:100%;" class="button-big-colse button-red">充值</a>
    <a href="<?= Url::toRoute('/product/index') ?>"  style="width:100%;" class="button-big-colse button-orange">提现</a>
</div>
<div class="decoration"></div>
<div class="container no-bottom">
    <a href="#" style="width:100%;" class="button-big-icon-colse icon-home button-white">快速分享<em class="go-right-member"></em></a>
    <a href="#" style="width:100%;" class="button-big-icon-colse icon-home button-white">基本信息<em class="go-right-member"></em></a>
    <a href="#" style="width:100%;" class="button-big-icon-colse icon-home button-white">我的银行<em class="go-right-member"></em></a>
    <a href="#" style="width:100%;" class="button-big-icon-colse icon-home button-white">收货地址<em class="go-right-member"></em></a>
    <a href="#" style="width:100%;" class="button-big-icon-colse icon-home button-white">资金明细<em class="go-right-member"></em></a>
</div>
<div class="decoration"></div>
<div class="container no-bottom">
    <a href="#" style="width:100%;" class="button-big-icon-colse icon-home button-white">已购商品<em class="go-right-member"></em></a>
    <a href="#" style="width:100%;" class="button-big-icon-colse icon-home button-white">我的商品<em class="go-right-member"></em></a>
    <a href="#" style="width:100%;" class="button-big-icon-colse icon-home button-white">物流进度<em class="go-right-member"></em></a>
</div>