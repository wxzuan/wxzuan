<?php
/* @var $this yii\web\View */
$this->title = '已购商品';

use frontend\services\OrderService;
use yii\widgets\ListView;
use frontend\extensions\scrollpager\ScrollPager;
use yii\helpers\Url;

$user_id = Yii::$app->user->getId();
$data = ['user_id' => $user_id, 'limit' => 10];
$productorders = OrderService::findBuyOrder($data);
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>
<div class="container no-bottom" style="padding:0px 10px;">
    <?php
    if ($productorders):
        echo ListView::widget([
            'dataProvider' => $productorders,
            'itemOptions' => ['class' => 'item'],
            'itemView' => '_item_product_fititem_view',
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