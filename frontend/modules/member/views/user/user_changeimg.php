<?php
/* @var $this yii\web\View */
$this->title = '上传头像';

use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Linkage;
use dosamigos\fileupload\FileUploadUI;
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>

<div class="container">
    <?=
    FileUploadUI::widget([
        'model' => $model,
        'attribute' => 'litpic',
        'url' => ['/uploadfile/userpic', 'id' => $model->user_id],
        'gallery' => TRUE,
        'fieldOptions' => [
            'accept' => 'image/*'
        ],
        'clientOptions' => [
            'maxFileSize' => 2000000
        ],
        // ...
        'clientEvents' => [
            'fileuploaddone' => 'function(e, data) {
                console.log(e);
                console.log(data);
                                }',
            'fileuploadfail' => 'function(e, data) {
                console.log(e);
                console.log(data);
                                }',
        ],
    ]);
    ?>
</div>
<a href="<?= Url::toRoute('/member/user/index') ?>"  style="width:100%;" class="button-big button-red">返回选择图片</a>