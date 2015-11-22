<?php
/* @var $this yii\web\View */
$this->title = '我的商品';

use frontend\services\ProductService;
use yii\helpers\Url;
use extensions\gallery\Gallery;
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>
<div class="container no-bottom" style="padding:0px 20px;">
    <?php $productlists = ProductService::findMyProducts(); ?>

    <ul class="gallery square-thumb">
        <?php
        if ($productlists):
            foreach ($productlists as $value) :
                ?>
                <li>
                    <a href="<?= Url::toRoute('/member/product/look/id/' . $value->product_id) ?>" title="<?= $value->product_name ?>">
                        <img src="<?= $value->product_s_img ?>" alt="img"></a>
                </li>
                <?php
            endforeach;
        endif;
        ?>
    </ul>   
</div>
<div class="decoration"></div>
<div class="container no-bottom" style="text-align: center;">
    <a href="<?= Url::toRoute('/index') ?>" class="button button-w button-white">返回首页</a>
    <a href="<?= Url::toRoute('/product/index') ?>" class="button button-w button-white">商品中心</a>
    <a href="<?= Url::toRoute('/help/index') ?>" class="button button-w button-white">帮助中心</a>
    <a href="<?= Url::toRoute('/help/contact') ?>" class="button button-w button-white">联系我们</a>
</div>