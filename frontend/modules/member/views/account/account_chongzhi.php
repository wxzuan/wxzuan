<?php
/* @var $this yii\web\View */
$this->title = '充值';

use yii\helpers\Url;
use frontend\services\AccountService;

$user_id = Yii::$app->user->getId();
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>
<div class="container no-bottom">
    <ul class="gallery square-thumb">
        <li>
            <a class="swipebox" href="images/gallery/full/1.jpg" title="An image caption!">
                <img src="/images/yuan10.gif" alt="img"></a>
        </li>
        <li>
            <a class="swipebox" href="images/gallery/full/2.jpg" title="It can change!">
                <img src="/images/yuan20.gif" alt="img"></a>
        </li>
        <li>
            <a class="swipebox" href="images/gallery/full/3.jpg" title="To be whatever you want!">
                <img src="/images/yuan50.gif" alt="img"></a>
        </li>
        <li>
            <a href="images/gallery/full/1.jpg" title="It's connected to the href!">
                <img src="/images/yuan100.gif" alt="img"></a>
        </li>
        <li>
            <a href="images/gallery/full/2.jpg" title="Easy to change and edit!">
                <img src="/images/yuan200.gif" alt="img"></a>
        </li>
        <li>
            <a href="images/gallery/full/3.jpg" title="What an awesome gallery!">
                <img src="/images/yuan500.gif" alt="img"></a>
        </li>
        <li>
            <a href="images/gallery/full/1.jpg" title="It's connected to the href!">
                <img src="/images/yuan1000.gif" alt="img"></a>
        </li>
        <li>
            <a href="images/gallery/full/2.jpg" title="Easy to change and edit!">
                <img src="/images/yuan5000.gif" alt="img"></a>
        </li>
        <li>
            <a href="images/gallery/full/3.jpg" title="What an awesome gallery!">
                <img src="/images/yuan10000.gif" alt="img"></a>
        </li>
    </ul>   
</div>
<div class="decoration"></div>
<div class="container no-bottom" style="text-align: center;">
    <a href="<?= Url::toRoute('/index') ?>" class="button button-w button-white">返回首页</a>
    <a href="<?= Url::toRoute('/product/index') ?>" class="button button-w button-white">商品中心</a>
    <a href="<?= Url::toRoute('/help/index') ?>" class="button button-w button-white">帮助中心</a>
    <a href="<?= Url::toRoute('/help/contact') ?>" class="button button-w button-white">联系我们</a>
</div>