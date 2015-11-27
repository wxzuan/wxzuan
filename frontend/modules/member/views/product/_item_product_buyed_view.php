<div class="one-half-responsive">
    <p class="quote-item">
        <img src="<?= $model->product->product_s_img; ?>" alt="img">
        商品名称：<?= $model->product->product_name ?> 支付：<?= $model->order_pay_price ?> 元 状态：<?= $model->getOrderStatus() ?>
        <em>送货地址：<?= $model->address ?></em>
    </p>
</div>