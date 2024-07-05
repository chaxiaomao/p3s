<?php

namespace common\components\actions\Wechat;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Url;

trait AttachmentUploadTrait {

    public function getFullStorePath() {
        if (!isset($this->_data['FullStorePath'])) {
            $this->_data['FullStorePath'] = Yii::getAlias($this->storePath) . DIRECTORY_SEPARATOR . Yii::$app->session->id;
            if (!is_dir($this->_data['FullStorePath'])) {
                FileHelper::createDirectory($this->_data['FullStorePath'], $this->dirMode, true);
            }
        }
        return $this->_data['FullStorePath'];
    }

    public function getFilePath($fileName) {
        return $this->getFullStorePath() . DIRECTORY_SEPARATOR . $fileName;
    }

    public function getFullStoreUrl() {
        if (!isset($this->_data['FullStoreUrl'])) {
            $this->_data['FullStoreUrl'] = Url::toRoute($this->storeUrl . '/' . Yii::$app->session->id);
        }
        return $this->_data['FullStoreUrl'];
    }

    public function getFileUrl($fileName) {
        return $this->getFullStoreUrl() . '/' . $fileName;
    }

}
