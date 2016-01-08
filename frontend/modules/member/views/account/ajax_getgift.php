<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<?php
if (!isset($p_param['sure'])):
    ?>
    <p>
        您确定现在就要领取这份奖品吗？
    </p>
    <div class="modal-footer">
        <?= Html::a('确认领取', FALSE, ['title' => '信息提示', 'value' => Url::toRoute('/member/account/getgift/'.$order->id.'/'.$order->ac_type) . '?sure=1', 'class' => 'btn btn-warning showModalButton']); ?>
        <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
    </div>
    <?php
else:
    ?>
    <p>
        <?php
        if ($fit['status'] == 1) {
            echo '领取成功';
            ?>
            <script type="text/javascript">
                $("#fit_gift_<?= $order->id ?>").html('已领取');
                $("#fit_gift_<?= $order->id ?>").removeClass("btn-danger showModalButton");
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