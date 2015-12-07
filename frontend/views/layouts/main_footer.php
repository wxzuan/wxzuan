<?php

use yii\helpers\Url;

$backurl = \Yii::$app->request->referrer;
if (strpos($backurl, 'notices')) {
    $backurl = '/';
}
?>
<div class="decoration"></div>

<div class="content-footer">
    <p class="copyright-content"> 版权 © 2015 .</p>
    <a href="#" class="go-up-footer"></a>
    <a href="<?= Url::toRoute('/member/index/index') ?>" class="facebook-footer"></a>
    <a href="<?= $backurl ?>" class="twitter-footer"></a>
    <div class="clear"></div>
</div>