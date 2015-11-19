<div class="container">
    <div class="toggle-1">
        <a href="#" class="deploy-toggle-1">
            <?= date('Y年m月d日H时i分s秒', $model->addtime) ?> <?= $model->getTypeRemark() ?> <?= $model->money ?> 元
        </a>
        <div class="toggle-content">
            <p>
                可用余额：<?= $model->use_money ?> 元<br/>
                备注：<?= $model->remark ?>
            </p>
        </div>
    </div>
</div>