<?php
/* @var $this yii\web\View */
$this->title = '银行卡信息';

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Linkage;
use common\models\Bankcard;
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>
<?php
$form = ActiveForm::begin([
            'action' => ['/member/index/bank'],
            'method' => 'post',
        ]);
?>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-1 toggle-1-active">所属银行<span class="float-right color-bule">查看</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'bank', ['labelOptions' => ['label' => '所属银行<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']])->dropDownList(Linkage::getValueChina("qys_none", "account_bank")); ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-1 toggle-1-active">帐号类型<span class="float-right color-bule">查看</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'bank_type', ['labelOptions' => ['label' => '帐号类型<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']])->dropDownList(['0' => '对私', '1' => '对公']); ?>            
        </div>
    </div>
</div>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-1 toggle-1-active">真实姓名<span class="float-right color-bule">查看</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'realname', [ 'labelOptions' => ['label' => '真实姓名<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-1 toggle-1-active">银行卡号<span class="float-right color-bule">查看</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'account', ['labelOptions' => ['label' => '银行卡号<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-1 toggle-1-active">银行所在地<span class="float-right color-bule">查看</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <div class="one-half" id="province_div">
                <select class="contactField requiredField">
                    <option>省份</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
            <div class="two-half last-column" id="city_div">
                <select name="city_code" class="contactField requiredField">
                    <option value="10">北京市</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-1 toggle-1-active">支行名称<span class="float-right color-bule">查看</span></a>
        <div class="toggle-content padding10" style="overflow: hidden;">
            <?= $form->field($model, 'branch', ['labelOptions' => ['label' => '支行名称<span>(必填)</span>', 'class' => 'field-title contactNameField'], 'inputOptions' => ['class' => 'contactField requiredField']]) ?>  
        </div>
    </div>
</div>
<div class="container no-bottom container-b">
    <?= Html::submitButton('修改银行卡', ['class' => 'buttonWrap button button-red contactSubmitButton', 'name' => 'submit-button']) ?>
</div>
<?php ActiveForm::end(); ?>
<?php
echo $this->render('bankpayaddressdiv');
?>
<script type="text/javascript">
    $(document).ready(function () {
<?php
$bankCard = Bankcard::find()->where("user_id=" . Yii::$app->user->getId())->one();
if ($bankCard->province) {
    ?>
            $(".qys_common_pay_provice").val(<?php echo $bankCard->province; ?>);
<?php } ?>
        var newprovice = $(".qys_common_pay_provice");
        $("#province_div").html(newprovice);
<?php
if ($bankCard->city) {
    ?>
            $(".qys_common_pay_city_<?php echo $bankCard->province; ?>").val(<?php echo $bankCard->city; ?>);
            var newcity = $(".qys_common_pay_city_<?php echo $bankCard->province; ?>");
<?php } else { ?>
            var newcity = $(".qys_common_pay_city_1");
<?php } ?>
        $("#city_div").html(newcity);
        $(".qys_common_pay_provice").bind('change', function () {
            var province = $(".qys_common_pay_provice").val();
            $("#qys_address_show").append(newcity);
            newcity = $(".qys_common_pay_city_" + province);
            $("#city_div").children().remove();
            $("#city_div").html(newcity);
        });
    });
</script>
<div class="container no-bottom" style="text-align: center;">
    <a href="<?= Url::toRoute('/index') ?>" class="button button-w button-white">返回首页</a>
    <a href="<?= Url::toRoute('/product/index') ?>" class="button button-w button-white">商品中心</a>
    <a href="<?= Url::toRoute('/help/index') ?>" class="button button-w button-white">帮助中心</a>
    <a href="<?= Url::toRoute('/help/contact') ?>" class="button button-w button-white">联系我们</a>
</div>