
<?php
/* @var $this yii\web\View */
$this->title = '添加好友';

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/lanmu/bannar_friend.jpg" alt="img">
</div>
<?= $this->render('@app/modules/member/views/layouts/l_member_header.php', ['icons' => ['product-content' => Url::toRoute('/member/friend/addfriend'), 'facebook-content' => Url::toRoute('/member/friend/index')]]); ?>
<?php
$form = ActiveForm::begin([
            'action' => ['/member/friend/addfriend'],
            'method' => 'post',
        ]);
?>
<div class="container ">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-1 toggle-1-active">好友用户名</a>
        <div class="toggle-content padding10" style="display: block;">
            <?= $form->field($model, 'username', ['labelOptions' => ['label' => '好友用户名<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container no-bottom container-b">
    <?= Html::submitButton('添加好友', ['class' => 'buttonWrap button button-red contactSubmitButton', 'name' => 'submit-button']) ?>
</div>
<?php ActiveForm::end(); ?>
<div class="decoration"></div>