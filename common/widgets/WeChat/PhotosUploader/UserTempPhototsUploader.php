<?php

namespace common\widgets\WeChat\PhotosUploader;

use Yii;
use cza\base\widgets\Widget;
use yii\web\HttpException;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;
use common\assets\JqueryWeui\JqueryWeuiAsset;
use yii\helpers\Json;
use cza\base\models\statics\OperationResult;
use yii\data\ArrayDataProvider;
use yii\base\DynamicModel;

/**
 * User temporary store upload files in wechat
 * @author Ben Bi <bennybi@qq.com>
 * @license
 */
class UserTempPhototsUploader extends PhotosUploader {

    use \common\components\actions\Wechat\AttachmentUploadTrait;

    protected $_data = [];
    public $model = null;
    public $groupCode = 'wx_album';
    public $storeUrl = '/uploads/temp';
    public $dataProvider = null;
    public $itemTpl = '<li class="weui-uploader__file" style="background-image:url(#url#)" id="#hash#", data-hash="#hash#"></li>';
    public $uploadAction = 'user-images-upload';
    public $deleteAction = 'user-images-delete';
    public $pageSize = 8;
    public $uiOptions = [];
    
    public function getDefaultOptions(){
        return [
            'title' => Yii::t('app.c2', 'Images Upload'),
            'galleryId' => 'userGallery',
            'galleryImgId' => 'userGalleryImg',
            'uploaderFilesId' => 'userUploaderFiles',
            'uploaderInputId' => 'userUploaderInput',
            'enableUpload' => true,
            'photoHandleCount' => 1, // 默认9，这里每次只处理一张照片
            'sizeType' => ["original", "compressed"], // 可以指定是原图还是压缩图，默认二者都有
        ];
    }

    public function run() {
        $this->dataProvider = new ArrayDataProvider([
            'allModels' => $this->getAllModels(),
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

    public function getAllModels() {
        $session = Yii::$app->session;
        $models = [];
        if ($session->has($this->groupCode)) {
            $items = $session[$this->groupCode];
//            Yii::info($items, 'debug');
            if (!empty($items)) {
                foreach ($items as $k => $v) {
                    $models[] = new DynamicModel([
                        'hash' => $k,
                        'url' => $this->getFileUrl($v),
                    ]);
                }
            }
        }
        return $models;
    }

//    public function getUrl($fileName) {
//        return $this->getFullStoreUrl() . '/' . $fileName;
//    }
//
//    public function getFullStoreUrl() {
//        if (!isset($this->_data['FullStoreUrl'])) {
//            $this->_data['FullStoreUrl'] = Url::toRoute($this->storeUrl . '/' . Yii::$app->session->id);
//        }
//        return $this->_data['FullStoreUrl'];
//    }
}
