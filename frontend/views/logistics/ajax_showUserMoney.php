<?php

use yii\helpers\Url;
?>
<?php
$usemoney = $oneAccount->use_money;
$paymoney = $logis->logis_bail;
if ($usemoney >= $paymoney):
    ?>
    <p>
        您当前可用资金为：<?= $oneAccount->use_money ?>。<br/>
        资金足以担保物品，确认要担保吗？
    </p>
    <div class="modal-footer">
        <a href="<?= Url::toRoute('/logistics/vouch/' . $logis->id) ?>" type="button" class="btn btn-warning">确认担保</a>
        <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
    </div>
    <?php
else:
    ?>
    <p>
        您当前可用资金为：<?= $oneAccount->use_money ?>。<br/>
        资金不足够担保物品，确认前往充值吗？
    </p>
    <div class="modal-footer">
        <a href="<?= Url::toRoute('/member/account/chongzhi') ?>" type="button" class="btn btn-warning">前往充值</a>
        <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
    </div>
<?php
endif;
?>