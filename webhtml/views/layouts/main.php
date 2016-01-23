<?php

use webhtml\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE HTML>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <meta name="keyword" content="赚赚,赚赚乐,转转,转转乐,收益平台,服务平台"/>
        <meta name="description" content="赚赚乐是寻想网络科技旗下开发的一款服务于大众的平台，平台允许用户发布买卖信息，物流信息来得到自己想要的服务。平台还推出理财服务,让用户的资金得以升值，赚赚,赚赚乐,转转,转转乐,收益平台,服务平台。"/>
        <meta/>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <!-- header -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img alt="Brand" width="150" height="30" src="/images/logo-dark.png">
                </a>
            </div>
        </nav>
        <div class="banner">
            <div class="container">
                <div class="col-md-6 Dayoh">
                    <h1>关注公众号</h1>
                    <div style="padding:5px;">
                        <h3>手机在手,赚赚赚！</h3>
                        <p>
                            扫描右边的微信二维码加入赚赚乐平台，每天即可以获取收益。<br/>
                            还可以天天抽奖哦。<br/>
                            快什么呢，快来加入我们吧！
                        </p>
                    </div>
                </div>
                <div class="col-md-6 Dayoh1" style="padding-top:10px;">
                    <img  style="margin: 0 auto;" src="/images/mobile.png" class="img-responsive" alt="" />
                </div>
                <div class="clearfix"> </div>
            </div> 
        </div>
        <!-- header -->
        <!-- featured -->
        <div class="featured">
            <div class="container">
                <div class="col-md-4">
                    <i class="time"> </i>
                    <h4>买卖方便</h4>
                    <p>即拍即卖，同城快速找到买家卖家。</p>
                </div>
                <div class="col-md-4">
                    <i class="mobile"> </i>
                    <h4>物流赚钱</h4>
                    <p>出差旅游也可以赚钱,综合物流资源。</p>
                </div>
                <div class="col-md-4">
                    <i class="eye"> </i>
                    <h4>轻松理财</h4>
                    <p>专业为你理财，既能办事又能赚钱</p>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
        <div class="footer">
            <div class="container">
                <div class="col-md-6">
                    <p>版权：赚赚乐网络服务平台</p>
                </div>
                <div class="col-md-6 social">
                    <ul>
                        <li><i class="mail"> </i></li>
                        <li><i class="fb"> </i></li>
                        <li><i class="twt"> </i></li>
                        <div class="clearfix"></div>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>