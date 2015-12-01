<?php
use yii\helpers\Url;
?>
<div class="decoration"></div>
<div class="container no-bottom">
    <img class="responsive-image" src="<?= $model->product_s_img ?>" alt="img">
</div>
<div class="section-title">
    <h4><?= $model->product_name ?><em>￥ <?= $model->product_price ?> 元</em></h4>
    <p style="line-height: 25px;margin-bottom: 10px;"><?= $model->product_description ?></p>
    <strong><a onclick ="return(confirm('确认购买吗？'))" href="<?= Url::toRoute('/product/buy/'.$model->product_id) ?>"<img src="/images/misc/icons/buy.png" width="20" alt="img"></a></strong>
</div>