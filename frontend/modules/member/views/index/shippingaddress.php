<?php
/* @var $this yii\web\View */
$this->title = '银行卡信息';

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\UserProductAddress;
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>
<?php
$form = ActiveForm::begin([
            'action' => ['/member/index/shippingaddress'],
            'method' => 'post',
        ]);
?>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-1 toggle-1-active">收货人姓名<span class="float-right color-bule">查看</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'realname', [ 'labelOptions' => ['label' => '收货人姓名<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-1 toggle-1-active">联系人手机<span class="float-right color-bule">查看</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'phone', [ 'labelOptions' => ['label' => '联系人手机<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-1 toggle-1-active">所在城市<span class="float-right color-bule">查看</span></a>
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
        <a href="#" class="deploy-toggle-1 toggle-1-active">收货人详细地址<span class="float-right color-bule">查看</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'address', [ 'labelOptions' => ['label' => '收货人详细地址<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container no-bottom container-b">
    <?= Html::submitButton('修改收货地址', ['class' => 'buttonWrap button button-red contactSubmitButton', 'name' => 'submit-button']) ?>
</div>
<?php ActiveForm::end(); ?>
<?php
echo $this->render('addressdiv');
?>
<script type="text/javascript">
    $(document).ready(function () {
<?php
$userprodaddress = UserProductAddress::find()->where("user_id=" . Yii::$app->user->getId())->one();
if ($userprodaddress->province) {
    ?>
            $(".qys_common_provice").val(<?php echo $userprodaddress->province; ?>);
<?php } ?>
        var newprovice = $(".qys_common_provice");
        $("#province_div").html(newprovice);
<?php
if ($userprodaddress->city) {
    ?>
            $(".qys_common_city_<?php echo $userprodaddress->province; ?>").val(<?php echo $userprodaddress->city; ?>);
            var newcity = $(".qys_common_city_<?php echo $userprodaddress->province; ?>");
<?php } else { ?>
            var newcity = $(".qys_common_city_110000");
<?php } ?>
        $("#city_div").html(newcity);
<?php
if ($userprodaddress->area) {
    ?>
            $(".qys_common_area_<?php echo $userprodaddress->city; ?>").val(<?php echo $userprodaddress->area; ?>);
            var newarea = $(".qys_common_area_<?php echo $userprodaddress->city; ?>");
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
<div class="container no-bottom" style="text-align: center;">
    <a href="<?= Url::toRoute('/index') ?>" class="button button-w button-white">返回首页</a>
    <a href="<?= Url::toRoute('/product/index') ?>" class="button button-w button-white">商品中心</a>
    <a href="<?= Url::toRoute('/help/index') ?>" class="button button-w button-white">帮助中心</a>
    <a href="<?= Url::toRoute('/help/contact') ?>" class="button button-w button-white">联系我们</a>
</div>