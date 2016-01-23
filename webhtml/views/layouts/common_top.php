<?php

use yii\helpers\Url;
?>
<div class="panel-heading">
    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
        <div class="btn-group" role="group" aria-label="First group">
            <a href="<?= Url::toRoute('/public/activity') ?>" class="btn btn-default">活动列表</a>
            <a href="<?= Url::toRoute('/public/publish') ?>" class="btn btn-default">现金活动</a>
            <a href="<?= Url::toRoute('/public/gift') ?>" class="btn btn-default">实物活动</a>
            <a href="<?= Url::toRoute('/public/coupon') ?>"  class="btn btn-default">优惠券活动</a>
        </div>
    </div>
</div>