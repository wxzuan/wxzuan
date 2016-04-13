<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="container no-bottom">
    <div class="section-title qys_tucao_title">
        <h4><a href="<?= Url::toRoute('/say/article/' . $model->id) ?>"><?= Html::encode($model->c_title) ?></a><span class="pull-right" style="margin-right: 20px;"><em style="color:#666;font-size: 12px;"><?= $model->c_addtime ?></em></span></h4>
        <ul class="icon-list qys_icon_list" style="margin:5px 0px;">
            <li class="bubble-list"><?= $model->c_nums ?></li>
            <li class="heart-list">0</li>

        </ul>
        <div style="clear: both;"></div>
        <p class="left-text">
            <?= Html::encode($model->c_content) ?>
        </p>
        <strong style="background-image: url('<?= ($model->user->litpic)?$model->user->litpic:'/images/wechat/huodong/product.jpg'; ?>');background-size:100% 100%;"><img src="/images/tucaocp.png" width="20" alt="img"></strong>
    </div>
</div>
<div class="decoration qys-decoration"></div>