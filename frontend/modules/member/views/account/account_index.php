<?php
/* @var $this yii\web\View */
$this->title = '资金明细';

use frontend\services\AccountService;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;

$user_id = Yii::$app->user->getId();
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/lanmu/zijidetail.jpg" alt="img">
</div>
<?php
$data = ['user_id' => $user_id, 'limit' => 10];
$accountlogs = AccountService::findAccountlog($data);
?>
<div class="one-half-responsive last-column padding15px">
    <?php if ($accountlogs['models']): ?>
        <?php
        Pjax::begin(['id' => 'loadpajax']);
        $begin = $accountlogs['pages']->getPage() * $accountlogs['pages']->pageSize + 1;
        $end = $begin + $accountlogs['pages']->getPageSize() - 1;
        if ($begin > $end) {
            $begin = $end;
        }
        ?>
        <div class="summary">第<b><?= $begin . '-' . $end ?></b>条，共<b><?= $accountlogs['pages']->totalCount ?></b>条数据.</div>
        <div>
            <?php
            foreach ($accountlogs['models'] as $onelog) :
                ?>
                <div class="container">

                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <?= date('Y年m月d日H时i分s秒', $onelog->addtime) ?> <?= $onelog->getTypeRemark() ?> <?= $onelog->money ?> 元
                        </div>
                        <div class="panel-body">
                            <table class="table table-striped" style="margin-bottom: 0px">
                                <tr><th>总资金</th><th>可用余额</th><th>冻结资金</th><th>待收资金</th></tr>
                                <tr><td><?= $onelog->total ?> 元</td><td><?= $onelog->use_money ?></td><td><?= $onelog->no_use_money ?></td><td><?= $onelog->collection ?></td></tr>
                                <tr><td colspan="4" class="text-left">备注：<?= $onelog->remark ?></td></tr>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
            ?>
        </div>
        <div class="text-center">
            <?php
            echo LinkPager::widget(['pagination' => $accountlogs['pages'],'maxButtonCount'=>5]);
            ?>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.deploy-toggle-1').on('click', function () {
                    $(this).parent().find('.toggle-content').toggle(100);
                    $(this).toggleClass('toggle-1-active');
                    return false;
                });
            });
        </script>
        <?php Pjax::end() ?>
    <?php else: ?>

        <div class="container" style="min-height: 350px;">
            <p>暂时没有资金记录</p>
        </div>
    <?php endif; ?>
</div>
<div class="decoration"></div>