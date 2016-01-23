<?php
$this->title = '没有登录';
$error = '您没有登录平台。';
$errordetail = '您没有登录本平台，需要关闭当前页面，在微信菜单重新获取登录权限。';
/* @var $this yii\web\View */
$msgs = [];
if (Yii::$app->session->hasFlash('wechat_fail')) {
    $msgss = Yii::$app->session->getFlash('wechat_fail');
    $msgs = $msgss[0];
    $error = $msgs['msgtitle'];
    $errordetail = $msgs['message'];
    $this->title = $error;
}
?>
<?= $this->render('@app/views/layouts/main_header.php'); ?>
<div class="content">
    <div class="container no-bottom">
        <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
    </div>
    <div class="section-title">
        <h4>操作提示</h4>
        <em><?= $error ?></em>
        <strong><img src="/images/misc/icons/flag.png" width="20" alt="img"></strong>
    </div>
    <div class="container no-bottom">
        <p>
            <?= $errordetail ?>
        </p>
    </div>
    <?php if ($msgs): ?>
        <div class="container no-bottom">
            <div class="one-half-responsive">
                <?php if ($msgs['type'] >= 3): ?>
                    <a href="<?= $msgs['tourl'] ?>"><div class="static-notification-red ">
                            <p class="center-text"><?= $msgs['totitle'] ?></p>
                        </div></a>
                <?php endif; ?>
                <?php if ($msgs['type'] >= 2): ?>
                    <a href="<?= $msgs['backurl'] ?>"><div class="static-notification-yellow">
                            <p class="center-text"><?= $msgs['backtitle'] ?></p>
                        </div></a>
                <?php endif; ?>
            </div>
            <div class="one-half-responsive last-column">
                <a href="/"><div class="static-notification-green">
                        <p class="center-text">返回首页</p>
                    </div></a>
            </div>  
        </div>
    <?php endif; ?>
    <?= $this->render('@app/views/layouts/main_footer.php'); ?>
</div>