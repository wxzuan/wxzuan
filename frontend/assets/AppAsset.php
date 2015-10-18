<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/style.css',
        'css/framework.css',
        'css/owl.carousel.css',
        'css/swipebox.css',
        'css/colorbox.css',
    ];
    public $js = [
        'js/jqueryui.js',
        'js/owl.carousel.min.js',
        'js/jquery.swipebox.js',
        //'js/colorbox.js',
        'js/snap.js',
        'js/contact.js',
        'js/custom.js',
        'js/framework.js',
        'js/framework.launcher.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];

}
