<?php
/* @var $this yii\web\View */
$this->title = '物流列表';

use frontend\services\CommentService;
use yii\helpers\Url;
use frontend\extensions\scrollpager\ScrollPager;
use yii\widgets\ListView;
?>
<?= $this->render('@app/views/layouts/main_header.php', ['icons' => ['product-content' => Url::toRoute('/say/saying'), 'twitter-content' => Url::toRoute('/index')]]); ?>
<?= $this->render('@app/views/layouts/servicesMenu.php'); ?>
<div class="content">
    <?php
    $data = ['limit' => 5, 'fee_lock' => 1];
    $logisticsLists = CommentService::findComments($data);
    if ($logisticsLists):
        echo ListView::widget([
            'dataProvider' => $logisticsLists,
            'itemOptions' => ['class' => 'item qys-item'],
            'itemView' => '_item_comment_view',
            'pager' => ['class' => ScrollPager::className()]
        ]);
    else:
        ?>

        <div class="container" style="min-height: 350px;">
            <p>没有人吐槽呢</p>
        </div>
    <?php endif; ?>
    <?= $this->render('@app/views/layouts/main_footer.php'); ?>
</div>
