<?php
/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
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
        <div class="panel-heading">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group" role="group" aria-label="First group">
                    <a href="<?= Url::toRoute('/public/activity') ?>" class="btn btn-default">活动列表</a>
                    <a href="<?= Url::toRoute('/public/publish') ?>" class="btn btn-default">现金活动</a>
                    <a type="button" class="btn btn-default">实物活动</a>
                    <a type="button" class="btn btn-default">优惠券活动</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <?php
            $form = ActiveForm::begin([
                        'action' => ['public/publish'],
                        'method' => 'post',
            ]);
            ?>
            <?= $form->field($model, 'activity_id', ['labelOptions' => ['label' => '请选择要发布的活动类型']])->dropDownList($model->showActivity()) ?>
            <?= $form->field($model, 'gift_name', ['labelOptions' => ['label' => '名称']]); ?>
            <?= $form->field($model, 'gift_price', ['labelOptions' => ['label' => '总资金']]); ?>
            <?= $form->field($model, 'gift_nums', ['labelOptions' => ['label' => '总发布数量']]); ?>
            <?= $form->field($model, 'gift_min', ['labelOptions' => ['label' => '最小抽奖金额']]); ?>
            <?= $form->field($model, 'gift_max', ['labelOptions' => ['label' => '最大抽奖金额']]); ?>
            <?= Html::submitButton('发布', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>   
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
</div>
