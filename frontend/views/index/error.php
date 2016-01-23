<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = '出错啦～';
?>
<?= $this->render('@app/views/layouts/main_header.php'); ?>
<div class="content">
    <div class="site-error">

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>

        <p>
            怎么办?当前页面飞到火星去了。
        </p>
        <p>
            没事啦，程序员正在造飞船。
        </p>

    </div>
    <?= $this->render('@app/views/layouts/main_footer.php'); ?>
</div>
