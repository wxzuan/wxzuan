<?php
/* @var $this yii\web\View */
$this->title = '会员中心';
use frontend\services\ProductService;
use app\models\Product;
use yii\helpers\Url;
?>
<a href="<?= Url::toRoute('/product/addproduct') ?>"  style="width:100%;" class="button-big button-red">添加商品</a>
<?php
$data=['limit'=>10];
$productlists=  ProductService::findProducts($data);
$newproduct=new Product();
foreach ($productlists as  $onProdcut) :
  $newproduct->setAttributes($onProdcut->attributes);  
?>
<div class="decoration"></div>
<div class="container no-bottom">
    <img class="responsive-image" src="<?= $newproduct->product_s_img ?>" alt="img">
</div>
<div class="section-title">
    <h4><?= $newproduct->product_name ?><em>￥ <?= $newproduct->product_price ?> 元</em></h4>
    <p style="line-height: 25px;margin-bottom: 10px;"><?= $newproduct->product_description ?></p>
    <strong><img src="/images/misc/icons/buy.png" width="20" alt="img"></strong>
</div>
<?php endforeach; ?>