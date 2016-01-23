<?php
/* @var $this yii\web\View */
$this->title = '基本信息';

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>
<?= $this->render('@app/modules/member/views/layouts/l_member_header.php', ['icons' => ['product-content' => Url::toRoute('/member/index/index'), 'facebook-content' => Url::toRoute('/product/index')]]); ?>

<?php
$form = ActiveForm::begin([
            'action' => ['/member/index/userinfo'],
            'method' => 'post',
        ]);
if ($model->real_status == 1) {
    $enable_real = TRUE;
} else {
    $enable_real = FALSE;
}
?>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-2 toggle-1-active">真实姓名<span class="float-right color-bule"><?= $enable_real ? '查看' : '修改' ?></span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'realname', ['labelOptions' => ['label' => '真实姓名<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-2 toggle-1-active">证件号码<span class="float-right color-bule"><?= $enable_real ? '查看' : '修改' ?></span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'card_id', ['enableAjaxValidation' => true, 'labelOptions' => ['label' => '证件号码<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-2 toggle-1-active">手机号码<span class="float-right color-bule"><?= $model->phone_status == 1 ? '修改' : '验证' ?></span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'phone', ['enableAjaxValidation' => true, 'labelOptions' => ['label' => '手机号码<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-2 toggle-1-active">邮件地址<span class="float-right color-bule"><?= $model->email_status == 1 ? '修改' : '验证' ?></span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'email', ['enableAjaxValidation' => true, 'labelOptions' => ['label' => '邮件地址<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container no-bottom container-b">
    <?= $form->field($model, "real_status", ['labelOptions' => ['label' => '']])->hiddenInput(); ?>
    <?= $form->field($model, "phone_status", ['labelOptions' => ['label' => '']])->hiddenInput(); ?>
    <?= $form->field($model, "email_status", ['labelOptions' => ['label' => '']])->hiddenInput(); ?>
    <?= Html::submitButton('保存', ['class' => 'buttonWrap button button-red contactSubmitButton', 'name' => 'submit-button']) ?>
</div>
<?php ActiveForm::end(); ?>