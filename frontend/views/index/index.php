<?php
/* @var $this yii\web\View */

use frontend\services\ProductService;
use yii\helpers\Url;

$this->title = '首页';
?>
<div class="container">
    <div class="slider-controls" data-snap-ignore="true">                
        <div>
            <img src="/images/wechat/huodong/sc_img_1.jpg" class="responsive-image" alt="img">
            <p class="title-slider-caption">
                <strong>迎接美丽</strong>
                <em>水质清丽，美丽可人。</em>
            </p>
        </div>

        <div>
            <img src="/images/wechat/huodong/sc_img_2.jpg" class="responsive-image" alt="img">
            <p class="small-slider-caption">享受你的财富之旅吧。</p>
        </div>

        <div>
            <img src="/images/wechat/huodong/sc_img_3.jpg" class="responsive-image" alt="img">
            <p class="title-slider-caption">
                <strong>快乐买卖</strong>
                <em>快捷方便，全民交易。</em>
            </p>
        </div>
        <div>
            <img src="/images/wechat/huodong/sc_img_4.jpg" class="responsive-image" alt="img">
            <p class="title-slider-caption">
                <strong>快乐买卖</strong>
                <em>快捷方便，全民交易。</em>
            </p>
        </div>
    </div>
    <a href="#" class="next-slider"></a>
    <a href="#" class="prev-slider"></a>
</div>
<div class="decoration"></div>
<div class="container no-bottom">
    <?php
    $indexproductlists = ProductService::findIndexLists(5);
    if ($indexproductlists):
        foreach ($indexproductlists as $oneproduct) {
            ?>
            <div>
                <p class="quote-item">
                    <img src="<?= $oneproduct->product_s_img ?>" alt="img">
                    <?= $oneproduct->product_name ?><br/>
                    <em>价格：<?= $oneproduct->product_price ?> 元</em>
                    <?= $oneproduct->product_description ?>

                </p>
            </div>
            <?php
        }
    endif;
    ?>

</div>  
<div class="decoration"></div>

<div class="container no-bottom">
    <div class="section-title">
        <h4>朋友，迎接您的财富!</h4>
        <em>在这个贫富不均的社会里，如何抓住机遇让自己致富呢？</em>
        <strong><img src="/images/misc/icons/leaf.png" width="20" alt="img"></strong>
    </div>
    <p>社会变化万千，财富机遇很多。宝马奔驰到处乱跑，为何没有你一个？赚赚乐是一个给用户创造收益的平台。欢迎您使用本平台，来加速您的财富之旅。</p>
</div>
<div class="decoration"></div>

<div class="container no-bottom">
    <div class="section-title">
        <h4>如何使用平台赚取收益？</h4>
        <em>使用多种途径获取资金</em>
        <strong><img src="/images/misc/icons/cog2.png" width="20" alt="img"></strong>
    </div>
    <p>购物消费、发布商品买卖交易都可以让您从其他人那里得到及时资源，从而减少繁琐的操作，及时将资源转化为收益。平台还会默默地为计算每一份收益哦。</p>
</div>
