<div class="one-half-responsive">
    <p class="quote-item" style="line-height: 25px;">
        <img src="<?= $model->product->product_s_img; ?>" alt="img">
        <a class="btn btn-sm btn-success">确认发货</a>
        <a class="btn btn-sm btn-danger">取消订单</a>
        <br/>
        原价：<?= $model->order_price ?> 元 实际支付：<?= $model->order_pay_price ?> 元
        <br/>
        商品名称：<?= $model->product->product_name ?> 下单时间：<?= date('Y-m-d H:i:s', $model->addtime) ?>
        <br/>
        <span style="color:red;">送货地址：<?= $model->address ?></span>
        <br/>

    </p>
</div>