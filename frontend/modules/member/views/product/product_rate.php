<?php
/* @var $this yii\web\View */
$this->title = '查询物流进度';

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Linkage;
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>
<?php
$form = ActiveForm::begin([
            'action' => ['/member/index/bank'],
            'method' => 'post',
        ]);
?>
<div class="container">
    <div class="toggle-1" style="background-color: #ffffff;">
        <a href="#" class="deploy-toggle-1 toggle-1-active">订单号<span class="float-right color-bule">查看</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;display: block;">
            <?= $form->field($model, 'orderno', [ 'labelOptions' => ['label' => '请输入订单号<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container">
    <div class="toggle-1" style="background-color: #ffffff;">
        <a href="#" class="deploy-toggle-1 toggle-1-active">快递公司<span class="float-right color-bule">查看</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;display: block;">
            <?= $form->field($model, 'ordercompany_type', ['labelOptions' => ['label' => '选择快递公司<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']])->dropDownList([1 => '顺丰快递', 2 => '圆通快递', 3 => '韵达快递', 4 => '申通快递', 5 => '中通快递', 6 => '天天快递', 7 => '快捷快递', 8 => 'EMS快递']); ?>
        </div>
    </div>
</div>
<div class="container no-bottom container-b">
    <?= Html::submitButton('查询进度', ['class' => 'buttonWrap button button-red contactSubmitButton', 'name' => 'submit-button']) ?>
</div>
<?php ActiveForm::end(); ?>
<div class="container no-bottom" style="text-align: center;">
    <a href="<?= Url::toRoute('/index') ?>" class="button button-w button-white">返回首页</a>
    <a href="<?= Url::toRoute('/product/index') ?>" class="button button-w button-white">商品中心</a>
    <a href="<?= Url::toRoute('/help/index') ?>" class="button button-w button-white">帮助中心</a>
    <a href="<?= Url::toRoute('/help/contact') ?>" class="button button-w button-white">联系我们</a>
</div>