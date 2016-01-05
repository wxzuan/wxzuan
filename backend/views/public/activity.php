<?php
/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;
use yii\grid\GridView;
use backend\models\GiftSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = '日志新版';

$giftSearch = new GiftSearch();
$dataProvider = new ActiveDataProvider([
    'query' => $giftSearch->find(),
    'pagination' => [
        'pagesize' => '10',
    ]
        ]);
?>
<div class="site-index">
    <?php
    echo Breadcrumbs::widget([
        'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
        'links' => [
            [
                'label' => '活动列表',
                'url' => ['public/activity'],
                'template' => "<li><b>{link}</b></li>\n", // template for this link only
            ],
        ],
    ]);
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group" role="group" aria-label="First group">
                    <a href="<?= Url::toRoute('/public/activity') ?>" class="btn btn-default">活动列表</a>
                    <a href="<?= Url::toRoute('/public/publish') ?>" class="btn btn-default">现金活动</a>
                    <a type="button" class="btn btn-default">实物活动</a>
                    <a type="button" class="btn btn-default">优惠券活动</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $giftSearch,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => '中奖用户',
                        'filter' => Html::activeTextInput($giftSearch, 'user_id', ['class' => 'form-control']),
                        'format' => 'raw',
                        'value' => function ($data) {
                    return $data->showUsername();
                }
                    ],
                    [
                        'label' => '活动类型',
                        'filter' => Html::activeTextInput($giftSearch, 'activity_id', ['class' => 'form-control']),
                        'format' => 'raw',
                        'value' => function ($data) {
                    return $data->activity->ac_cname;
                }
                    ],
                    [
                        'label' => '奖品名称',
                        'value' => function ($data) {
                            return $data->gift_name;
                        }
                    ],
                    [
                        'label' => '奖品价值',
                        'value' => function ($data) {
                            return $data->gift_price . '元';
                        }
                    ],
                    [
                        'label' => '是否已抽中',
                        'value' => function ($data) {
                            return $data->showGiftStaus();
                        }
                    ],
                    [
                        'label' => '添加时间',
                        'filter' => Html::activeTextInput($giftSearch, 'addtime', ['class' => 'form-control']),
                        'format' => 'raw',
                        'value' => function ($data) {
                    return $data->showData($data->addtime);
                }],
                    [
                        'label' => '中奖时间',
                        'filter' => Html::activeTextInput($giftSearch, 'updatetime', ['class' => 'form-control']),
                        'format' => 'raw',
                        'value' => function ($data) {
                    return $data->showData($data->updatetime);
                }],
                    [
                        'label' => '领奖时间',
                        'filter' => Html::activeTextInput($giftSearch, 'fittime', ['class' => 'form-control']),
                        'format' => 'raw',
                        'value' => function ($data) {
                    return $data->showData($data->fittime);
                }
                    ]
                ]
            ]);
            ?>
        </div>
    </div>
</div>
</div>
