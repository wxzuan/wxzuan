<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>
<a href="<?= Url::toRoute('/logistics/detail/' . $model->id) ?>"><div class="section-title">
        <div class="one-half-responsive qys-one-half-responsive" style="border-top:none; ">
            <p class="quote-item qys-quote-item">
                <img style="width:80px;height:60px;" src="<?= $model->logis_s_img ? $model->logis_s_img : '/images/wechat/huodong/product.jpg'; ?>" alt="img">
                佣金：￥ <span style="font-weight: 600;font-size:15px;color:red;"><?= round($model->logis_fee, 2) ?></span> 元 保证金：￥ <span style="font-weight: 600;font-size:15px;"><?= round($model->logis_bail, 2) ?></span> 元<br/>
                出发：<?= $model->user_country ?> <?= $model->user_province ?> <?= $model->user_city ?> <?= $model->user_area ?><br/>
                目的：<?= $model->logis_country ?> <?= $model->logis_provice ?> <?= $model->logis_city ?> <?= $model->logis_area ?><br/>
            </p>
        </div></div></a>
<div class="decoration qys-decoration"></div>