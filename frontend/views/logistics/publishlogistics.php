
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

if (!isset($p_param['id'])):
    $this->title = '发布物流信息';
else:
    $this->title = '修改物流信息';
endif;
?>
<?= $this->render('@app/views/layouts/main_header.php' ,['icons' => ['facebook-content' => Url::toRoute('/logistics/index'), 'twitter-content' => Url::toRoute('/index')]]); ?>
<div class="content">
    <?php
    $p_param = Yii::$app->request->get();
    $form = ActiveForm::begin([
                'method' => 'post',
    ]);
    ?>
    <?= $form->field($model, 'logis_name', ['labelOptions' => ['label' => '物品名称<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
    <?= $form->field($model, 'logis_bail', ['labelOptions' => ['label' => '物品保证金(元)<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
    <?= $form->field($model, 'logis_fee', ['labelOptions' => ['label' => '佣金<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>
    <?= $form->field($model, 'to_user_id', ['labelOptions' => ['label' => '收货用户<span>(必填)</span>', 'class' => 'field-title contactNameField']])->dropDownList($model->showUsername()) ?>
    <div class="form-group">
        <label class="field-title contactNameField">限制到达时间<span>(必填)</span></label>
        <?=
        DatePicker::widget([
            'model' => $model,
            'attribute' => 'logis_arrivetime',
            'language' => 'zh-CN',
            'template' => '{addon}{input}',
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-m-dd',
            ]
        ]);
        ?>
    </div>
    <?= $form->field($model, 'logis_description', ['labelOptions' => ['label' => '物品简介<span>(必填)</span>', 'class' => 'field-title contactNameField']])->textArea(['class' => 'contactTextarea requiredField']) ?>


    <?php if (!isset($p_param['id'])): ?>
        <?= Html::submitButton('发布物流信息', ['class' => 'buttonWrap button button-red contactSubmitButton', 'name' => 'submit-button']) ?>
    <?php else: ?>
        <?= Html::submitButton('修改物流信息', ['class' => 'buttonWrap button button-red contactSubmitButton', 'name' => 'submit-button']) ?>
        <a href="<?= Url::toRoute('/member/product/selectimg/' . $p_param['id']) ?>"  style="width:100%;" class="button-big button-red">选择物品图片</a>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>
    <?= $this->render('@app/views/layouts/main_footer.php'); ?>
</div>