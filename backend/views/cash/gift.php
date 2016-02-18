<?php
/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '日志新版';
?>
<div class="site-index">
    <?php
    echo Breadcrumbs::widget([
        'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
        'links' => [
            [
                'label' => '活动列表',
                'url' => ['public/activity'],
                'template' => "<li><b>{link}</b></li>\n", // template for this link only
            ],
        ],
    ]);
    ?>
    <div class="panel panel-default">
        <?= $this->render('@app/views/layouts/common_top.php'); ?>
        <div class="panel-body">
            <?php
            $form = ActiveForm::begin([
                        'action' => ['public/gift'],
                        'method' => 'post',
            ]);
            ?>
            <?= $form->field($model, 'activity_id', ['labelOptions' => ['label' => '请选择要发布的活动类型']])->dropDownList($model->showActivity()) ?>
            <?= $form->field($model, 'gift_name', ['labelOptions' => ['label' => '名称']]); ?>
            <?= $form->field($model, 'gift_price', ['labelOptions' => ['label' => '单个商品价值']]); ?>
            <?= $form->field($model, 'gift_nums', ['labelOptions' => ['label' => '总发布数量']]); ?>
            <?= Html::submitButton('发布', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>   
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
</div>
