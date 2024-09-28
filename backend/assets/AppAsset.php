<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle {

    //    public $sourcePath = '@app/themes/classic/assets';
    //    public $basePath = '@webroot';
    //    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        //        'css/bootstrap.min.css'
    ];
    public $js = [
        'js/app.js',
        //        'js/jquery-3.2.1.min.js',
        'js/jquery.multipleInput.min.js',
        'js/jquery-sortable.min.js',
        //        'js/bootstrap.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'dmstr\web\AdminLteAsset',
        'kartik\growl\GrowlAsset',
        'cza\base\assets\AppAsset',
    ];

    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];

    public function init() {
        $this->sourcePath = '@app/themes/' . CZA_BACKEND_THEME . '/assets';
        parent::init();
    }

    public static function register($view) {
        self::setupAssetsPublishUrls();  // setup assets publish urls
        return $view->registerAssetBundle(get_called_class());
    }

    public static function setupAssetsPublishUrls() {
        \Yii::$app->czaHelper->setEnvData('AdminlteAssets', \Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist'));
    }

}
