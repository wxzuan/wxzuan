<?php
/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Gift;

$this->title = '日志新版';

$giftSearch = new Gift();
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
                    <a type="button" class="btn btn-default">现金活动</a>
                    <a type="button" class="btn btn-default">实物活动</a>
                    <a type="button" class="btn btn-default">优惠券活动</a>
                </div>
                <div class="btn-group" role="group" aria-label="Second group">
                    <a href="<?= Url::toRoute('/public/publish') ?>" class="btn btn-default">发布活动</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <?php
            $form = ActiveForm::begin([
                        'action' => ['test/getpost'],
                        'method' => 'post',
            ]);
            ?>
            <?= $form->field($giftSearch, 'activity_id',['labelOptions' => ['label' => '请选择要发布的活动类型']])->dropDownList($giftSearch->showActivity()) ?>
            <div class="form-group">
                <label for="exampleInputEmail1">活动</label>
                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="exampleInputFile">File input</label>
                <input type="file" id="exampleInputFile">
                <p class="help-block">Example block-level help text here.</p>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox"> Check me out
                </label>
            </div>
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'submit-button']) ?>   
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
</div>
