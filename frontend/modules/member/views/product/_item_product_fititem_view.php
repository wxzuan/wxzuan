<div class="one-half-responsive">
    <p class="quote-item" style="line-height: 25px;">
        <img src="<?= $model->product->product_s_img; ?>" alt="img">
        商品名称：<h3><?= $model->product->product_name ?></h3><br/>
    下单时间：<span style="color:red;"><?= date('Y-m-d H:i:s', $model->addtime) ?></span>
</p>
<p class="quote-item" style="line-height: 25px;">
    原价：<?= $model->order_price ?> 元 实际支付：<?= $model->order_pay_price ?> 元
    <br/>
    送货地址：<?= $model->address ?>
</p>
<p><span class="pull-right"><a class="btn btn-sm btn-success">确认发货</a><a class="btn btn-sm btn-danger">取消订单</a></span></p>
</div>