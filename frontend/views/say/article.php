<?php
/* @var $this yii\web\View */

use frontend\services\CommentService;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;

$this->title = Html::encode($articleInfo->c_title);
?>
<?= $this->render('@app/views/layouts/main_header.php', ['icons' => ['product-content' => Url::toRoute('/say/saying'), 'twitter-content' => Url::toRoute('/index')]]); ?>
<?= $this->render('@app/views/layouts/servicesMenu.php'); ?>
<div class="content">
    <div class="container no-bottom">
        <div class="section-title" style='margin-bottom: 0px;'>
            <h4><?= Html::encode($articleInfo->c_title) ?></h4>
            <em><span class="pull-left user-list" style='width:15px;height:15px;background-size:100% 100%;margin-right: 5px;'></span> <?= $articleInfo->user->username ?></em>
            <strong style="background-image: url('<?= ($articleInfo->user->litpic) ? $articleInfo->user->litpic : '/images/wechat/huodong/product.jpg'; ?>');background-size:100% 100%;"><img src="/images/tucaocp.png" width="20" alt="img"></strong>
        </div>
        <ul class="icon-list qys_icon_list" style="margin:5px 0px;">
            <li class="bubble-list"><?= $articleInfo->c_nums ?></li>
            <li class="heart-list">0</li>

        </ul>
        <div style="clear: both;"></div>
        <p>
            <?= Html::encode($articleInfo->c_content) ?>
        </p>
    </div>
    <div class="decoration"></div>
    <?php
    $get = Yii::$app->request->get();
    $data = ['top_id' => $articleInfo->id, 'limit' => 10, 'get' => $get];
    $realyLists = CommentService::findRepays($data);
    ?>
    <div class="one-half-responsive last-column" style='border-top:none;'>
        <?php if ($realyLists['models']): ?>
            <?php
            Pjax::begin(['id' => 'loadpajax']);
            $begin = $realyLists['pages']->getPage() * $realyLists['pages']->pageSize + 1;
            $end = $begin + $realyLists['pages']->getPageSize() - 1;
            if ($begin > $end) {
                $begin = $end;
            }
            ?>
            <div class='container no-bottom'>
                <?php
                foreach ($realyLists['models'] as $onelog) :
                    if ($onelog->user_id == $articleInfo->user_id):
                        ?>
                        <em class="speach-right-title"><?= $articleInfo->user->username ?> <?= $onelog->c_addtime ?>:</em>
                        <p class="speach-right blue-bubble"><?= Html::encode($onelog->c_content) ?></p>
                        <div class="clear"></div>
                        <?php
                    else:
                        ?>
                        <em class="speach-left-title"><?= $onelog->user->username ?> <?= $onelog->c_addtime ?>:</em>
                        <p class="speach-left"><?= Html::encode($onelog->c_content) ?></p>
                        <div class="clear"></div>
                    <?php
                    endif;
                endforeach;
                ?>
            </div>
            <div class="text-center">
                <?php
                echo LinkPager::widget(['pagination' => $realyLists['pages']]);
                ?>
            </div>
            <?php Pjax::end() ?>
        <?php else: ?>

            <div class="container" style="min-height: 350px;">
                <p>暂时没有回复记录</p>
            </div>
        <?php endif; ?>
    </div>
    <div class="container no-bottom" style="padding: 5px;">
        <?= Html::a('回复', FALSE, ['title' => '回复信息', 'value' => Url::toRoute('/say/repay/' . $articleInfo->id), 'class' => 'btn btn-sm btn-primary pull-right showModalButton']); ?>
    </div>
    <?= $this->render('@app/views/layouts/main_footer.php'); ?>
</div>
