<?php
/* @var $this yii\web\View */
$this->title = '物流详情';

use yii\helpers\Url;
use yii\helpers\Html;
?>
<?= $this->render('@app/views/layouts/main_header.php', ['icons' => ['product-content' => Url::toRoute('/logistics/publishlogistics'), 'twitter-content' => Url::toRoute('/index')]]); ?>
<div class="content">
    <div class="container">
        <div class="tabs">
            <a href="#" class="tab-but tab-but-1-qys tab-active">物流信息</a>
            <a href="#" class="tab-but tab-but-2-qys">物流进度</a>     
        </div>
        <div class="tab-content tab-content-1-qys" style="overflow: hidden; display: block;">
            <div class="container no-bottom">
                <img class="responsive-image" src="<?= $model->logis_s_img ? $model->logis_s_img : '/images/product_demo.jpg' ?>" alt="img">
            </div>
            <div class="section-title">
                <h4><?= $model->logis_name ?></h4>
                <h4>佣金：<?= round($model->logis_fee, 2) ?> <em> 保证金：￥ <?= round($model->logis_bail, 2) ?> 元</em></h4>
                <p style="line-height: 25px;margin-bottom: 10px;">
                    出发地点： <?= $model->user_country ?> <?= $model->user_province ?> <?= $model->user_city ?> <?= $model->user_area ?><br/>
                    出货地址：<?= $model->user_address ?><br/>
                    目的地点： <?= $model->logis_country ?> <?= $model->logis_provice ?> <?= $model->logis_city ?> <?= $model->logis_area ?><br/>
                    收货地址：<?= $model->logis_detailaddress ?><br/>
                <div class="well">
                    <?= $model->logis_description ?>
                </div>
                </p>
                <strong><?= Html::a('<img src="/images/misc/icons/book.png" width="20" alt="img">', FALSE, ['title' => '信息提示', 'value' => Url::toRoute('/logistics/book/' . $model->id), 'class' => 'showModalButton']); ?></strong>
            </div>
        </div>
        <div class="tab-content tab-content-2-qys" style="overflow: hidden; display: none;">
            <p>
                内容建设中
            </p>
        </div>       
    </div>
    <?= $this->render('@app/views/layouts/main_footer.php'); ?>
</div>
