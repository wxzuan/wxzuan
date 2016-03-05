<?php

use yii\helpers\Url;
?>
<?php
$usemoney = $oneAccount->use_money;
$paymoney = $product->product_price;
if ($usemoney >= $paymoney):
    ?>
    <p>
        您当前可用资金为：<?= $oneAccount->use_money ?>。<br/>
        资金足够购买当前商品，确认购买当前商品吗？
    </p>
    <div class="modal-footer">
        <a href="<?= Url::toRoute('/product/buy/' . $product->product_id) ?>" type="button" class="btn btn-warning">确认购买</a>
        <a href="<?= Url::toRoute('/member/account/chongzhi') ?>" type="button" class="btn btn-success">微信支付</a>
        <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
    </div>
    <?php
else:
    ?>
    <p>
        您当前可用资金为：<?= $oneAccount->use_money ?>。<br/>
        资金不足够购买当前商品，确认前往充值吗？
    </p>
    <div class="modal-footer">
        <a href="<?= Url::toRoute('/member/account/chongzhi') ?>" type="button" class="btn btn-warning">前往充值</a>
        <a href="<?= Url::toRoute('/member/account/chongzhi') ?>" type="button" class="btn btn-success">微信支付</a>
        <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
    </div>
<?php
endif;
?>