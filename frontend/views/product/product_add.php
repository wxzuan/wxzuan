
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

if (!isset($p_param['id'])):
    $this->title = '添加商品';
else:
    $this->title = '修改商品';
endif;
?>
<a href="<?= Url::toRoute('/product/index') ?>"  style="width:100%;" class="button-big button-red">商品列表</a>
<?php
$p_param = Yii::$app->request->get();
$form = ActiveForm::begin([
            'method' => 'post',
        ]);
?>
<?= $form->field($model, 'product_name', ['labelOptions' => ['label' => '商品名称<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
<?= $form->field($model, 'product_price', ['labelOptions' => ['label' => '商品价格(元)<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
<?= $form->field($model, 'product_num', ['labelOptions' => ['label' => '商品数量<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>
<?= $form->field($model, 'product_description', ['labelOptions' => ['label' => '商品简介<span>(必填)</span>', 'class' => 'field-title contactNameField']])->textArea(['class' => 'contactTextarea requiredField']) ?>
<?= $form->field($model, 'product_info', ['labelOptions' => ['label' => '商品详情<span>(必填)</span>', 'class' => 'field-title contactNameField']])->textArea(['class' => 'contactTextarea requiredField']) ?>
<?php if (!isset($p_param['id'])): ?>
    <?= Html::submitButton('添加商品', ['class' => 'buttonWrap button button-red contactSubmitButton', 'name' => 'submit-button']) ?>
<?php else: ?>
    <?= Html::submitButton('修改商品', ['class' => 'buttonWrap button button-red contactSubmitButton', 'name' => 'submit-button']) ?>
    <a href="<?= Url::toRoute('/member/product/selectimg/' . $p_param['id']) ?>"  style="width:100%;" class="button-big button-red">选择商品图片</a>
<?php endif; ?>

<?php ActiveForm::end(); ?>