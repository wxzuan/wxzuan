<?php
/* @var $this yii\web\View */
$this->title = '我的好友';

use frontend\services\FriendService;
use yii\widgets\ListView;
use frontend\extensions\scrollpager\ScrollPager;
use yii\helpers\Url;
?>
<div class="container no-bottom">
    <img class="responsive-image" src="/images/lanmu/bannar_friend.jpg" alt="img">
</div>
<?= $this->render('@app/modules/member/views/layouts/l_member_header.php', ['icons' => ['product-content' => Url::toRoute('/member/friend/addfriend'), 'twitter-content' => Url::toRoute('/index')]]); ?>
<div class="container no-bottom" style="padding:0px 10px;">
    <?php
    $user_id = Yii::$app->user->getId();
    $data = ['user_id' => $user_id, 'limit' => 10];
    $productlists = FriendService::findFriends($data);
    if ($productlists):
        echo ListView::widget([
            'dataProvider' => $productlists,
            'itemOptions' => ['class' => 'item'],
            'itemView' => '_item_friend_index_view',
            'pager' => ['class' => ScrollPager::className()]
        ]);
    else:
        ?>
        <div class="container" style="min-height: 350px;">
            <p>暂时没有好友记录</p>
        </div>
    <?php endif; ?>
</div>
<div class="decoration"></div>