<?php
/* @var $this yii\web\View */
$this->title = '已购商品';

use frontend\services\OrderService;
use yii\widgets\ListView;
use frontend\extensions\scrollpager\ScrollPager;
use yii\helpers\Url;

$p_param = \Yii::$app->request->get();
if (!isset($p_param['status'])) {
    $status = 0;
} else {
    $status = intval($p_param['status']);
}
$user_id = Yii::$app->user->getId();
$data = ['user_id' => $user_id, 'limit' => 10, 'p_param' => $p_param];
$productorders = OrderService::findProductOrder($data);
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>
<div class="container">
    <div class="tabs">
        <a href="<?= Url::toRoute('/member/product/buyed') ?>" class="tab-but tab-but-1<?= $status == 0 ? ' tab-active' : ''; ?>">待处理</a>
        <a href="<?= Url::toRoute('/member/product/buyed') ?>?status=1" class="tab-but tab-but-2<?= $status == 1 ? ' tab-active' : ''; ?>">发货中</a>
        <a href="<?= Url::toRoute('/member/product/buyed') ?>?status=3" class="tab-but tab-but-3<?= $status == 3 ? ' tab-active' : ''; ?>">成功购买</a>
        <a href="<?= Url::toRoute('/member/product/buyed') ?>?status=2" class="tab-but tab-but-4<?= $status == 2 ? ' tab-active' : ''; ?>">商家取消</a>     
    </div>     
</div>
<div class="container no-bottom" style="padding:0px 10px;">
    <?php
    if ($productorders):
        echo ListView::widget([
            'dataProvider' => $productorders,
            'itemOptions' => ['class' => 'item'],
            'itemView' => '_item_product_buyed_view',
            'pager' => ['class' => ScrollPager::className()]
        ]);
    else:
        ?>
        <div class="container" style="min-height: 350px;">
            <p>暂时没有资金记录</p>
        </div>
<?php endif; ?>
</div>
<div class="decoration"></div>