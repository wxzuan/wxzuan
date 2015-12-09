<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="one-half-responsive">
    <p class="quote-item" style="line-height: 25px;">
        <img src="<?= $model->product->product_s_img; ?>" alt="img">
        商品名称：<strong><?= $model->product->product_name ?></strong><br/>
        下单时间：<span style="color:red;"><?= date('Y-m-d H:i:s', $model->addtime) ?></span>
    </p>
    <p class="quote-item" style="line-height: 25px;">
        原价：<?= $model->order_price ?> 元 实际支付：<?= $model->order_pay_price ?> 元
        <br/>
        送货地址：<?= $model->address ?>
    </p>
    <p>
        <span class="pull-right"  id="fit_order_<?= $model->order_id ?>">
            <?= Html::a('确认发货', FALSE, ['title' => '信息提示', 'value' => Url::toRoute('/member/product/suresellproduct/'.$model->order_id), 'class' => 'btn btn-sm btn-warning showModalButton']); ?>
            <?= Html::a('取消订单', FALSE, ['title' => '信息提示', 'value' => Url::toRoute('/member/product/cancelsellproduct/'.$model->order_id), 'class' => 'btn btn-sm btn-danger showModalButton']); ?>
        </span>
    </p>
</div>