<div class="one-half-responsive">
    <p class="quote-item" style="line-height: 25px;">
        <img src="<?= $model->product->product_s_img; ?>" alt="img">
        商品名称：<?= $model->product->product_name ?> 支付：<?= $model->order_pay_price ?> 元 状态：<?= $model->getOrderStatus() ?>
        <br/>
        下单时间：<?= date('Y-m-d H:i:s', $model->addtime) ?>
        <br/>
        <span style="color:red;">送货地址：<?= $model->address ?></span>
    </p>
</div>