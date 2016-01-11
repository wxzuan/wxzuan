<?php
/* @var $this yii\web\View */
$this->title = '商品列表';

use yii\helpers\Url;
use yii\helpers\Html;
?>
<?= $this->render('@app/views/layouts/main_header.php', ['icons' => ['product-content' => Url::toRoute('/logistics/publishlogistics'), 'twitter-content' => Url::toRoute('/index')]]); ?>
<?= $this->render('@app/views/layouts/servicesMenu.php'); ?>
<div class="content">
    <div class="container no-bottom">
        <img class="responsive-image" src="<?= $model->logis_s_img ? $model->logis_s_img : '/images/product_demo.jpg' ?>" alt="img">
    </div>
    <div class="section-title">
        <h4><?= $model->logis_name ?></h4>
        <h4>佣金：<?= $model->logis_fee ?> <em> 保证金：￥ <?= $model->logis_bail ?> 元</em></h4>
        <p style="line-height: 25px;margin-bottom: 10px;">
            出发地点: <?= $model->user_country ?> <?= $model->user_province ?> <?= $model->user_city ?> <?= $model->user_area ?><br/>
            目的地点: <?= $model->logis_country ?> <?= $model->logis_provice ?> <?= $model->logis_city ?> <?= $model->logis_area ?><br/>
        <div class="well">
            <?= $model->logis_description ?>
        </div>
        </p>
        <strong><?= Html::a('<img src="/images/misc/icons/book.png" width="20" alt="img">', FALSE, ['title' => '信息提示', 'value' => Url::toRoute('/logistics/book/' . $model->id), 'class' => 'showModalButton']); ?></strong>
    </div>
    <?= $this->render('@app/views/layouts/main_footer.php'); ?>
</div>
