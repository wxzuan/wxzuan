<?php
/* @var $this yii\web\View */

use yii\widgets\Breadcrumbs;
use yii\grid\GridView;
use backend\models\GiftSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

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
                    <a type="button" class="btn btn-default">活动列表</a>
                    <a type="button" class="btn btn-default">现金活动</a>
                    <a type="button" class="btn btn-default">实物活动</a>
                    <a type="button" class="btn btn-default">优惠券活动</a>
                </div>
                <div class="btn-group" role="group" aria-label="Second group">
                    <a href="<?= Url::toRoute('/public/publish') ?>" class="btn btn-default">发布活动</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $giftSearch,
            ]);
            ?>
        </div>
    </div>
</div>
</div>
