<?php

namespace common\widgets\Gridster;

use Yii;
use yii\web\AssetBundle;

/**
 * 
 * According to https://github.com/dsmorse/gridster.js
 * 
 * @author Ben Bi <bennybi@qq.com>
 * @license http://opensource.org/licenses/mit-license.php The MIT License (MIT)
 * @package yii2-gridster
 */
class GridsterAsset extends AssetBundle {

    public $sourcePath = '@common/widgets/Gridster/assets';
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];

    public $js = [
        'jquery.gridster.min.js',
//        'http://dsmorse.github.io/gridster.js/dist/jquery.gridster.min.js',
    ];
    public $css = [
        'jquery.gridster.min.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
