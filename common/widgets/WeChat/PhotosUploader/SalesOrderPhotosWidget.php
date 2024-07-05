<?php

namespace common\widgets\WeChat\PhotosUploader;

use Yii;
use cza\base\widgets\Widget;
use yii\web\HttpException;
use yii\helpers\ArrayHelper;
use cza\base\models\statics\OperationEvent;
use yii\helpers\Url;
use yii\web\View;
use common\assets\JqueryWeui\JqueryWeuiAsset;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use cza\base\models\statics\OperationResult;

/**
 *  PhotosUploader Widget
 * @author Ben Bi <bennybi@qq.com>
 * @license
 */
class SalesOrderPhotosWidget extends PhotosUploader {

    public $model = null;
    public $code = 'wx_album';
    public $dataProvider = null;
    public $itemTpl = '<li class="weui-uploader__file" style="background-image:url(#url#)" id="#hash#", data-hash="#hash#"></li>';
    public $uploadAction = 'images-upload';
    public $deleteAction = 'images-delete';
    public $pageSize = 8;
    public $uiOptions = [];

    public function getDefaultOptions(){
        return [
            'title' => Yii::t('app.c2', 'Images Upload'),
            'galleryId' => 'gallery',
            'galleryImgId' => 'galleryImg',
            'uploaderFilesId' => 'uploaderFiles',
            'uploaderInputId' => 'uploaderInput',
            'enableUpload' => false,
            'photoHandleCount' => 1, // 默认9，这里每次只处理一张照片
            'sizeType' => ["original", "compressed"], // 可以指定是原图还是压缩图，默认二者都有
        ];
    }

    public function run() {
        $this->dataProvider = new ActiveDataProvider([
            'query' => $this->model->getWorkOrderImages($this->code),
            'pagination' => [
                'pageSize' => $this->pageSize,
                'params' => Yii::$app->request->get(),
            ],
        ]);


        $items = $this->dataProvider->getModels();

        $this->registerClientEvents();
        $this->registerJs();
        return $this->render($this->template, ['items' => $items,]);
    }

}
