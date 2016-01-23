<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<a href="<?= Url::toRoute('/logistics/publishlogistics/' . $model->id) ?>"><div class="one-half-responsive">
        <p class="quote-item">
            <img src="<?= $model->logis_s_img ? $model->logis_s_img : '/images/product_demo.jpg'; ?>" alt="img">
            名称：<?= Html::encode($model->logis_name) ?> 价格：<?= $model->logis_fee ?> 元
        </p>
    </div></a>