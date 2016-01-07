<?php
/* @var $this yii\web\View */
$this->title = '提现记录';

use frontend\services\AccountService;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$user_id = Yii::$app->user->getId();
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/misc/help_server.png" alt="img">
</div>
<div class="container">
    <div class="tabs">
        <a href="<?= Url::toRoute('/member/account/coupon') ?>" class="tab-but tab-but-1">现金礼品</a>
        <a href="<?= Url::toRoute('/member/account/coupon').'?type=2' ?>" class="tab-but tab-but-1">实物礼品</a>
        <a href="<?= Url::toRoute('/member/account/coupon').'?type=3' ?>" class="tab-but tab-but-1 tab-active">优惠券礼品</a>     
    </div>     
</div>
<?php
$get=Yii::$app->request->get();
$data = ['user_id' => $user_id, 'limit' => 10,'get'=>$get];
$accountlogs = AccountService::findGift($data);
?>
<div class="one-half-responsive last-column">
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
                    <div class="toggle-1">
                        <a href="#" data-pjax="0" class="deploy-toggle-1">
                            <?= date('Y年m月d日H时i分s秒', $onelog->updatetime) ?>抽中价值<span style="color:red;"><?= $onelog->gift_price ?></span> 元 <?= $onelog->showFittimeRemark(0) ?> 
                        </a>
                        <div class="toggle-content">
                            <p>
                                奖品名称：<?= $onelog->gift_name ?> 元 价值：<?= $onelog->gift_price ?><br/>
                                中奖时间：<?= date('Y年m月d日H时i分s秒', $onelog->updatetime) ?><br/>
                                领取时间：<?= $onelog->showFittimeRemark(1) ?> <br/>
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
            echo LinkPager::widget(['pagination' => $accountlogs['pages']]);
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
            <p>暂时没有资金记录</p>
        </div>
    <?php endif; ?>
</div>
<div class="decoration"></div>