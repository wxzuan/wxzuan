<?php
/* @var $this yii\web\View */
$this->title = '基本信息';

use yii\widgets\ActiveForm;
use common\models\User;
use yii\helpers\Html;
use common\models\Linkage;
use yii\helpers\Url;
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>
<?= $this->render('@app/modules/member/views/layouts/l_member_header.php', ['icons' => ['product-content' => Url::toRoute('/product/index'), 'facebook-content' => Url::toRoute('/product/index')]]); ?>
<?php
$form = ActiveForm::begin([
            'action' => ['/member/user/info'],
            'method' => 'post',
        ]);
?>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-2 toggle-1-active">用户名<span class="float-right color-bule">查看</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'username', ['labelOptions' => ['label' => '用户名<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-2 toggle-1-active">所在城市<span class="float-right color-bule">查看</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <div class="one-third" id="province_div">
                <select class="contactField requiredField">
                    <option>省份</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
            <div class="one-third" id="city_div">
                <select name="city_code" class="contactField requiredField">
                    <option value="10">北京市</option>
                </select>
            </div>
            <div class="one-third last-column" id="area_div">
                <select name="city_code" class="contactField requiredField">
                    <option value="10">南城区</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-2 toggle-1-active">真实地址<span class="float-right color-bule">查看</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'address', ['enableAjaxValidation' => true, 'labelOptions' => ['label' => '真实地址<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-2 toggle-1-active">密保问题<span class="float-right color-bule">查看</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'question', ['labelOptions' => ['label' => '所属银行<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']])->dropDownList(Linkage::getValueChina("qys_none", "question")); ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-2 toggle-1-active">密保答案<span class="float-right color-bule">查看</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'answer', ['enableAjaxValidation' => true, 'labelOptions' => ['label' => '密保答案<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container no-bottom container-b">
    <?= Html::submitButton('修改信息', ['class' => 'buttonWrap button button-red contactSubmitButton', 'name' => 'submit-button']) ?>
</div>
<?php ActiveForm::end(); ?>
<?php
echo $this->render('addressdiv');
?>
<script type="text/javascript">
    $(document).ready(function () {
<?php
$user=User::find()->where("user_id=:user_id",[':user_id'=>$model->user_id])->one();
if ($user->province) {
    ?>
            $(".qys_common_provice").val(<?php echo $user->province; ?>);
<?php } ?>
        var newprovice = $(".qys_common_provice");
        $("#province_div").html(newprovice);
<?php
if ($user->city) {
    ?>
            $(".qys_common_city_<?php echo $user->province; ?>").val(<?php echo $user->city; ?>);
            var newcity = $(".qys_common_city_<?php echo $user->province; ?>");
<?php } else { ?>
            var newcity = $(".qys_common_city_110000");
<?php } ?>
        $("#city_div").html(newcity);
<?php
if ($user->area) {
    ?>
            $(".qys_common_area_<?php echo $user->city; ?>").val(<?php echo $user->area; ?>);
            var newarea = $(".qys_common_area_<?php echo $user->city; ?>");
<?php } else { ?>
            var newarea = $(".qys_common_area_110100");
<?php } ?>

        $("#area_div").html(newarea);
        $(".qys_common_provice").bind('change', function () {
            var province = $(".qys_common_provice").find("option").not(function () {
                return !this.selected;
            }).val();
            $("#qys_address_show").append(newcity);
            newcity = $(".qys_common_city_" + province);
            $("#city_div").html(newcity);
            var city = $("#city_div").children('select').find("option").not(function () {
                return !this.selected;
            }).val();
            $("#qys_address_show").append(newarea);
            newarea = $(".qys_common_area_" + city);
            $("#area_div").html(newarea);
        });
        $("#city_div").children('select').bind('change', function () {
            var city = $("#city_div").children('select').find("option").not(function () {
                return !this.selected;
            }).val();
            $("#qys_address_show").append(newarea);
            newarea = $(".qys_common_area_" + city);
            $("#area_div").html(newarea);
        });
    });
</script>