<?php
use yii\helpers\Url;

$thisactiveid=  strtolower(\Yii::$app->controller->id);
?>
<div class="content">
    <div class="container">
        <div class="tabs">
            <a href="<?= Url::toRoute('/member/logistics/index') ?>" class="tab-but tab-but-1<?= ($thisactiveid=='index')?' tab-active':''; ?>">我的寄出</a>
            <a href="<?= Url::toRoute('/member/logistics/mybook') ?>" class="tab-but tab-but-2<?= ($thisactiveid=='mybook')?' tab-active':''; ?>">我的接单</a>
            <a href="<?= Url::toRoute('/member/logistics/mygift') ?>" class="tab-but tab-but-3<?= ($thisactiveid=='mygift')?' tab-active':''; ?>">我的物品</a> 
        </div>     
    </div>
</div>