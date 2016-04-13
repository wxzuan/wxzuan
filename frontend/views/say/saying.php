
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

$this->title = '吐槽几句';
?>
<?= $this->render('@app/views/layouts/main_header.php', ['icons' => ['facebook-content' => Url::toRoute('/logistics/index'), 'twitter-content' => Url::toRoute('/index')]]); ?>
<div class="content">
    <?php
    $p_param = Yii::$app->request->get();
    $form = ActiveForm::begin([
                'method' => 'post',
    ]);
    ?>
    <?= $form->field($model, 'to_user_id', ['labelOptions' => ['label' => '吐槽用户<span>(必选)</span>', 'class' => 'field-title contactNameField']])->dropDownList($model->showUsername()) ?>
    <?= $form->field($model, 'is_public', ['labelOptions' => ['label' => '是否公布天下<span>(必选)</span>', 'class' => 'field-title contactNameField']])->dropDownList(['0' => '不公布', '1' => '公布']) ?>

    <?= $form->field($model, 'c_title', ['labelOptions' => ['label' => '主题<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
    <?= $form->field($model, 'c_content', ['labelOptions' => ['label' => '内容<span>(必填)</span>', 'class' => 'field-title contactNameField']])->textArea(['class' => 'contactTextarea requiredField']) ?>


    <?= Html::submitButton('吐槽', ['class' => 'buttonWrap button button-red contactSubmitButton', 'name' => 'submit-button']) ?>


    <?php ActiveForm::end(); ?>
    <?= $this->render('@app/views/layouts/main_footer.php'); ?>
</div>