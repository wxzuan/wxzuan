<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="decoration"></div>
<div class="section-title">
    <h4><?= $model->logis_name ?></h4>
    <div class="one-half-responsive" style="border-top:none; ">
        <p class="quote-item">
            <img src="<?= $model->user->litpic?$model->user->litpic:'/images/wechat/huodong/product.jpg'; ?>" alt="img">
            佣金：￥ <span style="font-weight: 600;font-size:15px;color:red;"><?= round($model->logis_fee,2) ?></span> 元 保证金：￥ <span style="font-weight: 600;font-size:15px;"><?= round($model->logis_bail,2) ?></span> 元<br/>
            出发地点: <?= $model->user_country ?> <?= $model->user_province ?> <?= $model->user_city ?> <?= $model->user_area ?><br/>
            目的地点: <?= $model->logis_country ?> <?= $model->logis_provice ?> <?= $model->logis_city ?> <?= $model->logis_area ?><br/>
        </p>
    </div>
    <strong><?= Html::a('<img src="/images/misc/icons/look.png" width="20" alt="img">', Url::toRoute('/logistics/detail/' . $model->id), ['title' => '查看详情']); ?></strong>
</div>