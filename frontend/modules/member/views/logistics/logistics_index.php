<?php
/* @var $this yii\web\View */
$this->title = '我的商品';

use frontend\services\LogisticsService;
use yii\widgets\ListView;
use frontend\extensions\scrollpager\ScrollPager;
use yii\helpers\Url;
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>
<div class="container no-bottom" style="padding:0px 10px;">
    <?php
    $user_id = Yii::$app->user->getId();
    $data = ['user_id' => $user_id, 'limit' => 5];
    $logisLists = LogisticsService::findMyLogiss($data);
    if ($logisLists):
        echo ListView::widget([
            'dataProvider' => $logisLists,
            'itemOptions' => ['class' => 'item'],
            'itemView' => '_item_logis_index_view',
            'pager' => ['class' => ScrollPager::className()]
        ]);
    else:
        ?>
        <div class="container" style="min-height: 350px;">
            <p>暂时没有物品记录</p>
        </div>
    <?php endif; ?>
</div>
<div class="decoration"></div>