<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="one-half-responsive">
    <p class="quote-item" style="line-height: 25px;">
        <img src="<?= $model->product->product_s_img; ?>" alt="img">
        商品名称：<?= $model->product->product_name ?> 支付：<?= $model->order_pay_price ?> 元 状态：<?= $model->getOrderStatus() ?>
        <br/>
        下单时间：<?= date('Y-m-d H:i:s', $model->addtime) ?>
        <br/>
        <span style="color:red;">送货地址：<?= $model->address ?></span>
    </p>
    <p>
        <span class="pull-right"  id="fit_order_<?= $model->order_id ?>">
            <?php
            switch ($model->order_status) {
                case 2:
                    ?>
                    <button class="btn btn-default btn-sm">已经取消</button>
                    <?php
                    break;
                case 3:
                    ?>
                    <button class="btn btn-default btn-sm">成功购买</button>
                    <?php
                    break;
                case 1:
                    ?>
                    <?= Html::a('确认收货', FALSE, ['title' => '信息提示', 'value' => Url::toRoute('/member/product/successbuy/' . $model->order_id), 'class' => 'btn btn-sm btn-warning showModalButton']); ?>
                    <?= Html::a('查询物流', FALSE, ['title' => '信息提示', 'value' => Url::toRoute('/member/product/rate/' . $model->order_id), 'class' => 'btn btn-sm btn-danger showModalButton']); ?>
                    <?php
                    break;
                default :
                    ?>
                    <button class="btn btn-default btn-sm">商户取消</button>
                <?php
            }
            ?>
        </span>
    </p>
</div>