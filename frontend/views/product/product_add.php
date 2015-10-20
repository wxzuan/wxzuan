<?php
/* @var $this yii\web\View */
$this->title = '添加商品';

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<a href="<?= Url::toRoute('/product/index') ?>"  style="width:100%;" class="button-big button-red">商品列表</a>
<?php
$form = ActiveForm::begin([
            'action' => ['product/addproduct'],
            'method' => 'post',
        ]);
?>
<?= $form->field($model, 'product_name', ['labelOptions' => ['label' => '商品名称<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
<?= $form->field($model, 'product_price', ['labelOptions' => ['label' => '商品价格(元)<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
<?= $form->field($model, 'product_num', ['labelOptions' => ['label' => '商品数量<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>
<?= $form->field($model, 'product_description', ['labelOptions' => ['label' => '商品简介<span>(必填)</span>', 'class' => 'field-title contactNameField']])->textArea(['class' => 'contactTextarea requiredField']) ?>
<?= $form->field($model, 'product_info', ['labelOptions' => ['label' => '商品详情<span>(必填)</span>', 'class' => 'field-title contactNameField']])->textArea(['class' => 'contactTextarea requiredField']) ?>
<?= Html::submitButton('添加商品', ['class' => 'buttonWrap button button-red contactSubmitButton', 'name' => 'submit-button']) ?>
<?php ActiveForm::end(); ?>