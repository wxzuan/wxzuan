<?php
/* @var $this yii\web\View */
$this->title = '提现';

use yii\helpers\Url;
use frontend\services\AccountService;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\Account;
use common\models\Bankcard;

$user_id = Yii::$app->user->getId();
$oneuseraccount = Account::find()->where('user_id=:user_id', [':user_id' => $user_id])->one();
$oneBank = Bankcard::find()->where('user_id=:user_id', [':user_id' => $user_id])->one();
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>
<div class="container no-bottom">
    <a href="#" style="width:100%;padding-left:13px;" class="button-big-icon-colse button-white">所属银行：<span class="float-right"><?= $oneBank->bank_name ?></span></a>
    <a href="#" style="width:100%;padding-left:13px;" class="button-big-icon-colse button-white">银行帐号：<span class="float-right"><?= '***'.substr($oneBank->account, -4) ?></span></a>
    <a href="#" style="width:100%;padding-left:13px;" class="button-big-icon-colse button-white">支行地址：<span class="float-right"><?= $oneBank->branch ?></span></a>
    <a href="#" style="width:100%;padding-left:13px;" class="button-big-icon-colse button-white">真实姓名：<span class="float-right"><?= $oneBank->realname; ?></span></a>
    <a href="#" style="width:100%;padding-left:13px;" class="button-big-icon-colse button-white">可用余额：<span class="float-right"><?= $oneuseraccount->use_money ?> 元</span></a>
</div>
<div class="decoration"></div>
<div class="container">
    <div class="toggle-1" style="background-color: #ffffff;">
        <div class="toggle-content padding10" style="overflow: hidden;display: block;">
            <?= $form->field($model, 'money', [ 'labelOptions' => ['label' => '请输入提现金额<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container no-bottom container-b">
    <?= Html::submitButton('确定提现', ['class' => 'buttonWrap button button-red contactSubmitButton', 'name' => 'submit-button']) ?>
</div>