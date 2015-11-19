<?php
/* @var $this yii\web\View */
$this->title = '商品列表';

use frontend\services\ProductService;
use yii\helpers\Url;
use frontend\extensions\scrollpager\ScrollPager;
use yii\widgets\ListView;
?>
<a href="<?= Url::toRoute('/product/addproduct') ?>"  style="width:100%;" class="button-big button-red">添加商品</a>
<?php
$data = ['limit' => 10];
$productlists = ProductService::findProducts($data);
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
