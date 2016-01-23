<?php
/* @var $this yii\web\View */
$this->title = '联系我们';
?>
<?= $this->render('@app/views/layouts/main_header.php'); ?>
<div class="content">
    <div class="container no-bottom">
        <img class="responsive-image" src="/images/misc/help_contacts.gif" alt="img">
    </div>
    <div class="section-title">
        <h4>联系电话</h4>
        <em>0755-12345678</em>
        <strong><img src="/images/misc/icons/flag.png" width="20" alt="img"></strong>
    </div>
    <p>
        很明显，这个电话假的。本平台暂时不对外公布电话号码。<br/>
        服务会在7*24时无间为您服务。
    </p>
    <div class="decoration"></div>
    <div class="container no-bottom">
        <div class="section-title">
            <h4>咨询邮箱</h4>
            <em>zuanzuanle@aliyun.com</em>
            <strong><img src="/images/misc/icons/flag.png" width="20" alt="img"></strong>
        </div>
        <p>
            此邮箱是正常有效的，大家有什么意义可以直接级此邮箱留言。<br/>
            对于有利的建议会有时给您回复，必要时可留下电话号码及各种可以联系到您的方式
        </p>
    </div>
    <div class="decoration"></div>
    <div class="container no-bottom">
        <div class="section-title">
            <h4>公司地址</h4>
            <em>广东省深圳市罗湖区</em>
            <strong><img src="/images/misc/icons/flag.png" width="20" alt="img"></strong>
        </div>
        <p>
            范围太大，你找不到的啦。后期会有具体的地址给出。
        </p>
    </div>
    <?= $this->render('@app/views/layouts/main_footer.php'); ?>
</div>
