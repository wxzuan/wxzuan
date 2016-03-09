<?php
/* @var $this yii\web\View */
$this->title = '商品列表';

use frontend\services\ProductService;
use yii\helpers\Url;
use frontend\extensions\scrollpager\ScrollPager;
use yii\widgets\ListView;
?>
<?= $this->render('@app/views/layouts/main_header.php', ['icons' => ['product-content' => Url::toRoute('/product/addproduct'), 'twitter-content' => Url::toRoute('/index')]]); ?>
<?= $this->render('@app/views/layouts/servicesMenu.php'); ?>
<div class="content">
    <?php
    $data = ['limit' => 5];
    $productlists = ProductService::findProducts($data,true);
    if ($productlists):
        echo ListView::widget([
            'dataProvider' => $productlists,
            'itemOptions' => ['class' => 'item'],
            'itemView' => '_item_product_view',
            'pager' => ['class' => ScrollPager::className()]
        ]);
    else:
        ?>

        <div class="container" style="min-height: 350px;">
            <p>还没有发布商品</p>
        </div>
    <?php endif; ?>
    <?= $this->render('@app/views/layouts/main_footer.php'); ?>
</div>
