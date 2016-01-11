<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="decoration"></div>
<div class="section-title">
    <h4><?= $model->logis_name ?></h4>
    <h4>佣金：<?= $model->logis_fee ?> <em> 保证金：￥ <?= $model->logis_bail ?> 元</em></h4>
    <p style="line-height: 25px;margin-bottom: 10px;">
        出发地点: <?= $model->user_country ?> <?= $model->user_province ?> <?= $model->user_city ?> <?= $model->user_area ?><br/>
        目的地点: <?= $model->logis_country ?> <?= $model->logis_provice ?> <?= $model->logis_city ?> <?= $model->logis_area ?><br/>
    </p>
    <strong><?= Html::a('<img src="/images/misc/icons/look.png" width="20" alt="img">', FALSE, ['title' => '查看详情', 'value' => Url::toRoute('/logistics/detail/' . $model->id)]); ?></strong>
</div>