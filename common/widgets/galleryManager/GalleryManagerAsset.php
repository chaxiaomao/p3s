<?php

namespace common\widgets\galleryManager;

use Yii;
use yii\web\AssetBundle;

class GalleryManagerAsset extends AssetBundle
{
    public $sourcePath = '@common/widgets/galleryManager/assets';
    public $js = [
        'layui.all.js',
        'jquery.iframe-transport.js',
        'jquery.galleryManager.js',
        'jquery.fancybox.min.js'
    ];
    public $css = [
        'galleryManager.css',
        'jquery.fancybox.min.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset'
    ];

}
