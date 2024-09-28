<?php

namespace common\components\Chat;

use yii\web\AssetBundle;

/**
 * Class ChatLibAsset
 * @package jones\wschat
 */
class ChatLibAsset extends AssetBundle {

    public $sourcePath = '@vendor/bower-asset';
    public $css = [
        'fontawesome/css/font-awesome.min.css',
        'pnotify/pnotify.core.css',
    ];
    public $js = [
        'underscore/underscore-min.js',
        'backbone/backbone.js',
        'js-cookie/src/js.cookie.js',
        'pnotify/pnotify.core.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
    public $publishOptions = [
//        'forceCopy' => YII_DEBUG,
        'forceCopy' => false,
    ];

}
