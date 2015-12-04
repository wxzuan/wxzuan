<?php
/* @var $this yii\web\View */
$this->title = '我的商品';

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Linkage;
use dosamigos\fileupload\FileUploadUI;
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>

<div class="container no-bottom" style="padding:0px 10px;">
    <div class="section-title">
        <h4><?= Html::encode($model->product_name) ?></h4>
        <em>下面为当前商品已选择的图片</em>
    </div>
    <div class="section">
        <img class="responsive-image" src="<?= $model->product_s_img ? $model->product_s_img : '/images/product_demo.jpg'; ?>" alt="img">
    </div>
</div>
<div class="container no-bottom" style="padding:0px 10px;">
    <div class="section-title">
        <h4>选择商品图片</h4>
        <em>如果没有理想图片，请从右边添加新图片。</em>
        <strong><a href="<?= Url::toRoute('/member/product/changeimg/' . $model->product_id) ?>"><img src="/images/misc/icons/addpic.png" width="20" alt="img"></a></strong>
    </div>
</div>
<div class="container no-bottom" style="padding:0px 10px;">
    <ul class="gallery square-thumb">
        <li>
            <a class="swipebox" href="/images/general-nature/1.jpg" title="An image caption!">
                <img src="/images/general-nature/1s.jpg" alt="img"></a>
        </li>
        <li>
            <a class="swipebox" href="/images/general-nature/2.jpg" title="It can change!">
                <img src="/images/general-nature/2s.jpg" alt="img"></a>
        </li>
        <li>
            <a class="swipebox" href="/images/general-nature/3.jpg" title="To be whatever you want!">
                <img src="/images/general-nature/3s.jpg" alt="img"></a>
        </li>
        <li>
            <a class="swipebox" href="/images/general-nature/1.jpg" title="It's connected to the href!">
                <img src="/images/general-nature/4s.jpg" alt="img"></a>
        </li>
        <li>
            <a class="swipebox" href="/images/general-nature/2.jpg" title="Easy to change and edit!">
                <img src="/images/general-nature/5s.jpg" alt="img"></a>
        </li>
        <li>
            <a class="swipebox" href="/images/general-nature/3.jpg" title="What an awesome gallery!">
                <img src="/images/general-nature/6s.jpg" alt="img"></a>
        </li>
    </ul>   
</div>
<div class="container no-bottom" style="text-align: center;">
    <a href="<?= Url::toRoute('/index') ?>" class="button button-w button-white">返回首页</a>
    <a href="<?= Url::toRoute('/product/index') ?>" class="button button-w button-white">商品中心</a>
    <a href="<?= Url::toRoute('/help/index') ?>" class="button button-w button-white">帮助中心</a>
    <a href="<?= Url::toRoute('/help/contact') ?>" class="button button-w button-white">联系我们</a>
</div>