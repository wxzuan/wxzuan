<?php
/* @var $this yii\web\View */
$this->title = '基本信息';

use frontend\services\ProductService;
use app\models\Product;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>
<?php
$form = ActiveForm::begin([
            'action' => ['/member/index/userinfo'],
            'method' => 'post',
        ]);
?>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-1 toggle-1-active">真实姓名<span class="float-right color-bule">增加</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'realname', ['labelOptions' => ['label' => '真实姓名<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-1 toggle-1-active">证件号码<span class="float-right color-bule">增加</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'card_id', ['enableAjaxValidation' => true, 'labelOptions' => ['label' => '证件号码<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-1 toggle-1-active">手机号码<span class="float-right color-bule">增加</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'phone', ['enableAjaxValidation' => true, 'labelOptions' => ['label' => '手机号码<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-1 toggle-1-active">邮件地址<span class="float-right color-bule">增加</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'email', ['enableAjaxValidation' => true, 'labelOptions' => ['label' => '邮件地址<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container no-bottom container-b">
    <?= Html::submitButton('修改信息', ['class' => 'buttonWrap button button-red contactSubmitButton', 'name' => 'submit-button']) ?>
</div>
<?php ActiveForm::end(); ?>
<div class="container no-bottom" style="text-align: center;">
    <a href="<?= Url::toRoute('/index') ?>" class="button button-w button-white">返回首页</a>
    <a href="<?= Url::toRoute('/product/index') ?>" class="button button-w button-white">商品中心</a>
    <a href="<?= Url::toRoute('/help/index') ?>" class="button button-w button-white">帮助中心</a>
    <a href="<?= Url::toRoute('/help/contact') ?>" class="button button-w button-white">联系我们</a>
</div>