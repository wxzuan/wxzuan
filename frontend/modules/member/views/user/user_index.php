<?php
/* @var $this yii\web\View */
$this->title = '我的头像';

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Linkage;
use dosamigos\fileupload\FileUploadUI;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>

<div class="container no-bottom" style="padding:0px 10px;">
    <div class="section-title">
        <h4>用户名 ：<?= Html::encode($model->username) ?></h4>
        <em>当前头像</em>
    </div>
    <div class="section">
        <img class="responsive-image" src="<?= $model->litpic ? $model->litpic : '/images/product_demo.jpg'; ?>" alt="img">
    </div>
</div>
<div class="container no-bottom" style="padding:0px 10px;">
    <div class="section-title">
        <h4>选择头像</h4>
        <em>如果没有理想图片，请从右边添加新图片。</em>
        <strong><a href="<?= Url::toRoute('/member/user/changeimg') ?>"><img src="/images/misc/icons/addpic.png" width="20" alt="img"></a></strong>
    </div>
</div>
<?php
$form = ActiveForm::begin([
            'method' => 'post',
            'fieldConfig' => ['template' => '{input}',]
        ]);
?>
<?= $form->field($model, 'litpic')->hiddenInput(['id' => 'selectimg']) ?>
<div class="container no-bottom" style="padding:0px 10px;">
    <?php Pjax::begin(['id' => 'loadpajax']); ?>
    <div>
        <ul class="gallery square-thumb">
            <?php
            if ($models):
                foreach ($models as $onepic) :
                    ?>
                    <li>
                        <a id="selectimg<?= $onepic->id ?>" tval='<?= $onepic->id ?>' class="box_picselect" data-pjax="0" href="javascript:js_method(<?= $onepic->id ?>);" title="图片<?= $onepic->id ?>">
                            <img src="<?= $onepic->pic_s_img ?>" alt="img">
                        </a>
                    </li>
                    <?php
                endforeach;
            endif;
            ?>
        </ul>
    </div>
    <div class="text-center">
        <?php
        if ($models):
            echo LinkPager::widget(['pagination' => $pages]);
        endif;
        ?>
    </div>
    <?php Pjax::end() ?>
</div>
<script type="text/javascript">
    function js_method(obj) {
        $(".box_picselect").css("border", "none");
        $("#selectimg" + obj).css("border", "2px solid green");
        $("#selectimg").val($("#selectimg" + obj).attr('tval'));
        return false;
    }
</script>
<?= Html::submitButton('确认图片', ['class' => 'buttonWrap button button-red contactSubmitButton', 'name' => 'submit-button']) ?>
<?php ActiveForm::end(); ?>