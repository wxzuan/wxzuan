<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="decoration"></div>
<div class="container no-bottom">
    <img class="responsive-image" src="<?= $model->logis_s_img ? $model->logis_s_img : '/images/product_demo.jpg' ?>" alt="img">
</div>
<div class="section-title">
    <h4><?= $model->logis_name ?></h4>
    <h4>佣金：<?= $model->logis_fee ?> <em> 保证金：￥ <?= $model->logis_bail ?> 元</em></h4>
    <p style="line-height: 25px;margin-bottom: 10px;">
        出发地点: <?= $model->user_country ?> <?= $model->user_province ?> <?= $model->user_city ?> <?= $model->user_area ?><br/>
        详细地点：<?= $model->user_address ?> <br/>
        目的地点: <?= $model->logis_country ?> <?= $model->logis_provice ?> <?= $model->logis_city ?> <?= $model->logis_area ?><br/>
        详细地点：<?= $model->logis_detailaddress ?> <br/>
    <div class="well">
        <?= Html::encode($model->logis_description) ?>
    </div>
</p>
<strong><?= Html::a('<img src="/images/misc/icons/buy.png" width="20" alt="img">', FALSE, ['title' => '信息提示', 'value' => Url::toRoute('/logistics/takeing/' . $model->id), 'class' => 'showModalButton']); ?></strong>
</div>