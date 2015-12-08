<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="decoration"></div>
<div class="container no-bottom">
    <img class="responsive-image" src="<?= $model->product_s_img ? $model->product_s_img : '/images/product_demo.jpg' ?>" alt="img">
</div>
<div class="section-title">
    <h4><?= $model->product_name ?><em>￥ <?= $model->product_price ?> 元</em></h4>
    <p style="line-height: 25px;margin-bottom: 10px;"><?= $model->product_description ?></p>
    <strong><?= Html::a('<img src="/images/misc/icons/buy.png" width="20" alt="img">', FALSE, ['title' => '确定购买吗？', 'value' => Url::toRoute('/product/showmymoney'), 'class' => 'showModalButton']); ?></strong>
</div>