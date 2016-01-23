<?php
/* @var $this yii\web\View */
$this->title = '帮助中心';
?>
<?= $this->render('@app/views/layouts/main_header.php'); ?>
<div class="content">
    <div class="container no-bottom">
        <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
    </div>
    <div class="section-title">
        <h4>产品服务</h4>
        <em>产品渠道都以正常渠道邮寄给客户。</em>
        <strong><img src="/images/misc/icons/flag.png" width="20" alt="img"></strong>
    </div>
    <p>
        随着科学技术的进步，产品技术越来越复杂，消费者对企业的依赖性越来越大。他们购买产品时．不仅购买产品本身，而且希望在购买产品后，得到可靠而周到的服务。企业的质量保证、服务承诺、服务态度和服务效率，已成为消费者判定产品质量，决定购买与否的一个重要条件。对于生产各种设备和耐用消费品的企业，做好产品服务工作显得尤为重要，可以提高企业的竞争能力，赢得重复购买的机会。
    </p>
    <div class="decoration"></div>
    <div class="container no-bottom">
        <div class="section-title">
            <h4>产品对象</h4>
            <em>产品只面对微信用户开放</em>
            <strong><img src="/images/misc/icons/applications.png" width="20" alt="img"></strong>
        </div>
        <p>
            本平台产品只卖给通过微信注册成本平台的用户，通过其他方式注册成为本平台的用户，需要绑定微信帐号，才能使用本平台的功能。及购买本平台产品。
        </p>
    </div>
    <div class="decoration"></div>
    <div class="container no-bottom">
        <div class="section-title">
            <h4>产品邮寄</h4>
            <em>正常的邮寄渠道</em>
            <strong><img src="/images/misc/icons/applications.png" width="20" alt="img"></strong>
        </div>
        <p>
            凡是本平台的用户，如果你初次购买没有配送地址时，将要对您的基本信息进行完善。基本信息完善后，就可直接购买产品。
        </p>
    </div>
    <div class="decoration"></div>
    <div class="container no-bottom">
        <div class="section-title">
            <h4>充值</h4>
            <em>只允许微信充值</em>
            <strong><img src="/images/misc/icons/applications.png" width="20" alt="img"></strong>
        </div>
        <p>
            你可以使用微信支付充值本网站资金。
        </p>
    </div>
    <div class="decoration"></div>
    <div class="container no-bottom">
        <div class="section-title">
            <h4>提现</h4>
            <em>提现需完善必要资料</em>
            <strong><img src="/images/misc/icons/applications.png" width="20" alt="img"></strong>
        </div>
        <p>
            申请提现时，如果您的资料没有完善，需要完善您的资料。
        </p>
    </div>
    <?= $this->render('@app/views/layouts/main_footer.php'); ?>
</div>