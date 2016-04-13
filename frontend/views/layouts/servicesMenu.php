<?php

use yii\helpers\Url;

$thisactiveid = strtolower(\Yii::$app->controller->id);
?>
<div class="content">
    <div class="container">
        <div class="tabs">
            <a href="<?= Url::toRoute('/product/index') ?>" class="tab-but tab-but-1<?= ($thisactiveid == 'product') ? ' tab-active' : ''; ?>">商品区</a>
            <a href="<?= Url::toRoute('/logistics/index') ?>" class="tab-but tab-but-2<?= ($thisactiveid == 'logistics') ? ' tab-active' : ''; ?>">物运区</a>
            <a href="<?= Url::toRoute('/product/index') ?>" class="tab-but tab-but-3">理财区</a>
            <a href="<?= Url::toRoute('/say/index') ?>" class="tab-but tab-but-4<?= ($thisactiveid == 'say') ? ' tab-active' : ''; ?>">吐槽区</a>     
        </div>     
    </div>
</div>