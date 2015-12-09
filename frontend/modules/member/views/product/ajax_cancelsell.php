<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php
if (!isset($p_param['sure'])):
    ?>
    <p>
        您确定要取消该笔订单吗？
    </p>
    <div class="modal-footer">
    <?= Html::a('确定取消', FALSE, ['title' => '信息提示', 'value' => Url::toRoute('/member/product/cancelsellproduct/' . $order->order_id) . '?sure=1', 'class' => 'btn btn-warning showModalButton']); ?>
        <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
    </div>
    <?php
else:
    ?>
    <p>
        <?php
        if ($fit['status'] == 1) {
            echo '取消成功';
            ?>
            <script type="text/javascript">
                $("#fit_order_<?= $order->order_id ?>").html('<button class="btn btn-default btn-sm">取消成功</button>');
            </script>
            <?php
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