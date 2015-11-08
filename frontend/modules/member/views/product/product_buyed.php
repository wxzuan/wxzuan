<?php
/* @var $this yii\web\View */
$this->title = '已购商品';

use frontend\services\OrderService;
use yii\helpers\Url;

$user_id = Yii::$app->user->getId();
$data = ['user_id' => $user_id, 'limit' => 10];
$productorders = OrderService::findProductOrder($data);
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>
<div class="container no-bottom" style="padding:0px 10px;">
    <?php
    if ($productorders):
        foreach ($productorders as $oneproductorder):
            ?>
            <div class="one-half-responsive">
                <p class="quote-item">
                    <img src="<?= $oneproductorder->product->product_s_img; ?>" alt="img">
                    商品名称：<?= $oneproductorder->product->product_name ?> 支付：<?= $oneproductorder->order_pay_price ?> 元 状态：<?= $oneproductorder->getOrderStatus() ?>
                    <em>送货地址：<?= $oneproductorder->address ?></em>
                </p>
            </div>
            <?php
        endforeach;
    else:
        ?>
        <div class="container" style="min-height: 350px;">
            <p>暂时没有资金记录</p>
        </div>
    <?php endif; ?>
</div>
<div class="decoration"></div>
<div class="container no-bottom" style="text-align: center;">
    <a href="<?= Url::toRoute('/index') ?>" class="button button-w button-white">返回首页</a>
    <a href="<?= Url::toRoute('/product/index') ?>" class="button button-w button-white">商品中心</a>
    <a href="<?= Url::toRoute('/help/index') ?>" class="button button-w button-white">帮助中心</a>
    <a href="<?= Url::toRoute('/help/contact') ?>" class="button button-w button-white">联系我们</a>
</div>