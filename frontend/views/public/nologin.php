<?php
/* @var $this yii\web\View */
$this->title = '没有登录';
?>
<?= $this->render('@app/views/layouts/main_header.php'); ?>
<div class="content">
    <div class="container no-bottom">
        <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
    </div>
    <div class="section-title">
        <h4>操作提示</h4>
        <em>您没有登录平台。</em>
        <strong><img src="/images/misc/icons/flag.png" width="20" alt="img"></strong>
    </div>
    <p>
        您没有登录本平台，需要关闭当前页面，在微信菜单重新获取登录权限。
    </p>
    <?= $this->render('@app/views/layouts/main_footer.php'); ?>
</div>