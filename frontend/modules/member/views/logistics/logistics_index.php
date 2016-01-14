<?php
/* @var $this yii\web\View */
$this->title = '我的商品';

use frontend\services\LogisticsService;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use yii\helpers\Url;
use yii\helpers\Html;

$user_id = Yii::$app->user->getId();
$get = Yii::$app->request->get();
$showtype = 1;
if (isset($get['type'])) {
    $showtype = intval($get['type']);
}
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>
<div class="container padding15px">
    <div class="tabs">
        <a href="<?= Url::toRoute('/member/logistics/index') ?>" class="tab-but tab-but-1<?= ($showtype == 1) ? ' tab-active' : ''; ?>">我的寄出</a>
        <a href="<?= Url::toRoute('/member/logistics/mybook') . '?type=2' ?>" class="tab-but tab-but-1<?= ($showtype == 2) ? ' tab-active' : ''; ?>">我的接单</a>
        <a href="<?= Url::toRoute('/member/logistics/mygift') . '?type=3' ?>" class="tab-but tab-but-1<?= ($showtype == 3) ? ' tab-active' : ''; ?>">我的物品</a>     
    </div>     
</div>
<?php
$data = ['user_id' => $user_id, 'limit' => 10];
$logisLists = LogisticsService::findMyLogiss($data);
?>
<div class="one-half-responsive last-column padding15px">
    <?php if ($logisLists['models']): ?>
        <?php
        Pjax::begin(['id' => 'loadpajax']);
        $begin = $logisLists['pages']->getPage() * $logisLists['pages']->pageSize + 1;
        $end = $begin + $logisLists['pages']->getPageSize() - 1;
        if ($begin > $end) {
            $begin = $end;
        }
        ?>
        <div class="summary">第<b><?= $begin . '-' . $end ?></b>条，共<b><?= $logisLists['pages']->totalCount ?></b>条数据.</div>
        <div>
            <?php
            foreach ($logisLists['models'] as $oneItem) :
                ?>
                <div class="container">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <?= $oneItem->showFitButton(0) ?>
                        </div>
                        <div class="panel-body">
                            <p class="panel-p">
                            <p class="quote-item">
                                <img src="<?= $oneItem->logis_s_img ? $oneItem->logis_s_img : '/images/product_demo.jpg'; ?>" alt="img">
                                <a href="<?= Url::toRoute('/logistics/publishlogistics/' . $oneItem->id) ?>">名称：<?= Html::encode($oneItem->logis_name) ?></a>
                                佣金：<?= $oneItem->logis_fee ?> 元
                            </p>
                            </p>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
            ?>
        </div>
        <div class="text-center">
            <?php
            echo LinkPager::widget(['pagination' => $logisLists['pages']]);
            ?>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.deploy-toggle-1').on('click', function() {
                    $(this).parent().find('.toggle-content').toggle(100);
                    $(this).toggleClass('toggle-1-active');
                    return false;
                });
            });
        </script>
        <?php Pjax::end() ?>
    <?php else: ?>

        <div class="container" style="min-height: 350px;">
            <p>暂时没有物品记录</p>
        </div>
    <?php endif; ?>
</div>
<div class="decoration"></div>