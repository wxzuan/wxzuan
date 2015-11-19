<?php
/* @var $this yii\web\View */
$this->title = '资金明细';

use yii\helpers\Url;
use frontend\services\AccountService;
use yii\widgets\ListView;
use frontend\extensions\scrollpager\ScrollPager;

$user_id = Yii::$app->user->getId();
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>
<div class="one-half-responsive last-column">
    <?php
    $data = ['user_id' => $user_id, 'limit' => 10];
    $accountlogs = AccountService::findAccountlog($data);
    if ($accountlogs):
        echo ListView::widget([
            'dataProvider' => $accountlogs,
            'itemOptions' => ['class' => 'item'],
            'itemView' => '_item_view',
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
<div class="container no-bottom" style="text-align: center;">
    <a href="<?= Url::toRoute('/index') ?>" class="button button-w button-white">返回首页</a>
    <a href="<?= Url::toRoute('/product/index') ?>" class="button button-w button-white">商品中心</a>
    <a href="<?= Url::toRoute('/help/index') ?>" class="button button-w button-white">帮助中心</a>
    <a href="<?= Url::toRoute('/help/contact') ?>" class="button button-w button-white">联系我们</a>
</div>