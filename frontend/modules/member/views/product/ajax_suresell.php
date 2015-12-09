<?php

use yii\helpers\Url;
?>
<?php
if (!isset($p_param['sure'])):
    ?>
    <p>
        您确定要给该笔订单发货吗？
    </p>
    <div class="modal-footer">
        <a href="<?= Url::toRoute('/member/product/suresellproduct/' . $order->order_id) ?>?sure=1" type="button" class="btn btn-warning">确定发货</a>
        <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
    </div>
    <?php
else:
    ?>
    <p>
        <?php
        if ($fit['status'] == 1) {
            echo '取消成功';
        } else {
            echo $fit['remark'];
        }
        ?>
    </p>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
    </div>
<?php
endif;
?>