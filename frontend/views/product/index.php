<?php
/* @var $this yii\web\View */
$this->title = '商品列表';
use frontend\services\ProductService;
use app\models\Product;
?>
<?php
$data=['limit'=>10];
$productlists=  ProductService::findProducts($data);
$newproduct=new Product();
foreach ($productlists as  $onProdcut) :
  $newproduct->setAttributes($onProdcut->attributes);  
?>
<div class="decoration"></div>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>
<div class="section-title">
    <h4><?= $newproduct->product_name ?></h4>
    <em><?= $newproduct->product_description ?></em>
    <strong><img src="/images/misc/icons/flag.png" width="20" alt="img"></strong>
</div>
<p>
    <?= $newproduct->product_info ?>
</p>
<?php endforeach; ?>