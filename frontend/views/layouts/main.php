<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE HTML>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
        <?= Html::csrfMetaTags() ?>
        <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/images/splash/splash-icon.png">
        <link rel="apple-touch-startup-image" href="/images/splash/splash-screen.png" 			media="screen and (max-device-width: 320px)" />  
        <link rel="apple-touch-startup-image" href="/images/splash/splash-screen_402x.png" 		media="(max-device-width: 480px) and (-webkit-min-device-pixel-ratio: 2)" /> 
        <link rel="apple-touch-startup-image" sizes="640x1096" href="/images/splash/splash-screen_403x.png" />
        <link rel="apple-touch-startup-image" sizes="1024x748" href="/images/splash/splash-screen-ipad-landscape" media="screen and (min-device-width : 481px) and (max-device-width : 1024px) and (orientation : landscape)" />
        <link rel="apple-touch-startup-image" sizes="768x1004" href="/images/splash/splash-screen-ipad-portrait.png" media="screen and (min-device-width : 481px) and (max-device-width : 1024px) and (orientation : portrait)" />
        <link rel="apple-touch-startup-image" sizes="1536x2008" href="/images/splash/splash-screen-ipad-portrait-retina.png"   media="(device-width: 768px)	and (orientation: portrait)	and (-webkit-device-pixel-ratio: 2)"/>
        <link rel="apple-touch-startup-image" sizes="1496x2048" href="/images/splash/splash-screen-ipad-landscape-retina.png"   media="(device-width: 768px)	and (orientation: landscape)	and (-webkit-device-pixel-ratio: 2)"/>

        <title><?= Html::encode($this->title . '|' . Yii::$app->name) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <div id="preloader">
            <div id="status">
                <p class="center-text">
                    加载中...
                    <em>加载取决于您的网络速度</em>
                </p>
            </div>
        </div>
        <div class="all-elements">
            <?= $this->render('sider') ?>
            <div id="content" class="page-content">
                <div class="page-header">
                    <a href="#" class="deploy-sidebar"></a>
                    <p class="bread-crumb"><?= Html::encode($this->title) ?></p>
                    <a href="<?= Url::toRoute('member/index') ?>" class="deploy-member"></a>
                </div>

                <?= $content ?>

            </div>  
        </div>

    </body>
    <?php $this->endBody() ?>
</html>
<?php $this->endPage() ?>
























