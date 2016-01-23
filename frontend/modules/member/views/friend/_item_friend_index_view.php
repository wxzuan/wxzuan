<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<a href="#">
    <div class="one-half-responsive">
        <p class="quote-item">
            <img src="<?= $model->user->litpic ? $model->user->litpic : '/images/product_demo.jpg'; ?>" alt="img">
            用户名：<?= Html::encode($model->user->username) ?>
            <em> 添加时间：<?= date('Y-m-d', $model->addtime) ?></em>
        </p>
    </div>
</a>