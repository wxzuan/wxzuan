<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="content">
    <?php
    $p_param = \Yii::$app->request->get();
    $form = ActiveForm::begin([
                'method' => 'post',
    ]);
    ?>
    <?= $form->field($model, 'top_id', ['labelOptions' => ['label' => '', 'style' => 'display:none;']])->hiddenInput() ?>
    <?= $form->field($model, 'c_content', ['labelOptions' => ['label' => '内容<span>(必填)</span>', 'class' => 'field-title contactNameField']])->textArea(['class' => 'contactTextarea requiredField']) ?>
    <?= Html::submitButton('回复', ['class' => 'buttonWrap button button-red contactSubmitButton', 'name' => 'submit-button']) ?>
    <?php ActiveForm::end(); ?>
</div>