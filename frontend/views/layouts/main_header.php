<?php

use yii\helpers\Url;

$defaultShowString = '<a href="' . Url::toRoute('/product/index') . '" class="facebook-content"></a><a href="' . Url::toRoute('/index') . '" class="twitter"></a>';
if (isset($icons)) {
    $defaultShowString = '';
    foreach ($icons as $key => $value) {
        $defaultShowString.='<a href="' . $value . '" class="' . $key . '"></a>';
    }
}
?>
<div class="content-header">
    <a href="<?= Url::toRoute('index') ?>" class="content-logo"></a>
    <?= $defaultShowString ?>
</div>