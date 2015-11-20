<?php
/**
 * @link https://github.com/2amigos/yii2-gallery-widget
 * @copyright Copyright (c) 2013-2015 2amigOS! Consulting Group LLC
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace extensions\gallery;

use yii\web\AssetBundle;

/**
 * GalleryAsset
 *
 * @author Alexander Kochetov <creocoder@gmail.com>
 */
class GalleryAsset extends AssetBundle
{
    public $sourcePath = '@extensions/gallery';
    public $css = [
        'css/blueimp-gallery.min.css',
    ];
    public $js = [
        'js/blueimp-gallery.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
