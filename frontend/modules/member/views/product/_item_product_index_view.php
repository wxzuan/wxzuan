<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<a href="<?= Url::toRoute('/product/addproduct/'.$model->product_id) ?>"><div class="one-half-responsive">
        <p class="quote-item">
            <img src="<?= $model->product_s_img; ?>" alt="img">
            商品名称：<?= Html::encode($model->product_name) ?> 价格：<?= $model->product_price ?> 元
            <em> 状态：<?= $model->getProductStatus() ?></em>
        </p>
    </div></a>