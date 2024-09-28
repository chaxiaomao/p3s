<?php

namespace common\models\c2\entity;

use Yii;
use common\models\c2\statics\EntityAttachmentType;
use yii\base\Exception;
use yii\helpers\Url;
use yii\helpers\FileHelper;
//use cza\base\models\statics\ImageSize;
use common\models\c2\statics\EshopImageSize as ImageSize;
use cza\base\models\statics\EntityModelState;

class EntityAttachmentImage extends EntityAttachment {

    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
        $this->type = EntityAttachmentType::TYPE_IMAGE;
    }

    public function behaviors() {
        return array_replace_recursive(parent::behaviors(), [
            'image' => [
                'class' => \cza\base\behaviors\ImageBehavior::className(),
                'versions' => [
                    ImageSize::ICON => ['resize' => ImageSize::getSize(ImageSize::ICON)],
                    ImageSize::THUMBNAIL => ['resize' => ImageSize::getSize(ImageSize::THUMBNAIL)],
                    ImageSize::MEDIUM => ['resize' => ImageSize::getSize(ImageSize::MEDIUM)],
                ],
            ]
        ]);
    }

    public function getAlt() {
        return !empty($this->label) ? $this->label : $this->name;
    }

    public function getIcon() {
        if (!isset($this->_data['icon'])) {
            $this->_data['icon'] = ImageSize::ICON . '/' . $this->hash . '.' . $this->extension;
        }
        return $this->_data['icon'];
    }

    public function getStoreUrl() {
        if (isset($this->_data['storeUrl'])) {
            return $this->_data['storeUrl'];
        }

        if (Yii::$app->settings->get('url\cdn_enable') == EntityModelState::STATUS_ENABLE) {
            if ($this->isVideo()) {
                $cdn = empty(Yii::$app->settings->get('url\cdn_video_base_url')) ? Yii::$app->settings->get('url\cdn_image_base_url') : Yii::$app->settings->get('url\cdn_video_base_url');
                $this->_data['storeUrl'] = !empty($cdn) ? $cdn : parent::getStoreUrl();
            } else {
                $this->_data['storeUrl'] = !empty(Yii::$app->settings->get('url\cdn_image_base_url')) ? Yii::$app->settings->get('url\cdn_image_base_url') : parent::getStoreUrl();
            }
        }

        return parent::getStoreUrl();
    }

    public function getIconUrl() {
        if (!isset($this->_data['iconUrl'])) {
            $this->_data['iconUrl'] = $this->getStoreUrl() . '/' . $this->getLogicPath() . $this->getIcon();
        }
        return $this->_data['iconUrl'];
    }

    public function getThumbnail() {
        if (!isset($this->_data['thumbnail'])) {
            $this->_data['thumbnail'] = ImageSize::THUMBNAIL . '/' . $this->getHashFileName();
        }
        return $this->_data['thumbnail'];
    }

    public function getThumbnailUrl() {
        if (!isset($this->_data['thumbnailUrl'])) {
            $this->_data['thumbnailUrl'] = $this->getStoreUrl() . '/' . $this->getLogicPath() . $this->getThumbnail();
        }
        return $this->_data['thumbnailUrl'];
    }

    public function getOrginal() {
        if (!isset($this->_data['orginal'])) {
            $this->_data['orginal'] = $this->getHashFileName();
        }
        return $this->_data['orginal'];
    }

    public function getOriginalUrl() {
        if (!isset($this->_data['orginalUrl'])) {
            $this->_data['orginalUrl'] = $this->getStoreUrl() . '/' . $this->getLogicPath() . $this->getOrginal();
        }
        return $this->_data['orginalUrl'];
    }

    public function getMedium() {
        if (!isset($this->_data['medium'])) {
            $this->_data['medium'] = ImageSize::MEDIUM . '/' . $this->getHashFileName();
        }
        return $this->_data['medium'];
    }

    public function getMediumUrl() {
        if (!isset($this->_data['mediumUrl'])) {
            $this->_data['mediumUrl'] = $this->getStoreUrl() . '/' . $this->getLogicPath() . $this->getMedium();
        }
        return $this->_data['mediumUrl'];
    }

    public function getUrlByFormat($format = ImageSize::MEDIUM) {
        $url = "";
        switch ($format) {
            case ImageSize::ICON:
                $url = $this->getIconUrl();
                break;
            case ImageSize::MEDIUM:
                $url = $this->getMediumUrl();
                break;
            case ImageSize::ORGINAL:
                $url = $this->getOriginalUrl();
                break;
            case ImageSize::THUMBNAIL:
                $url = $this->getThumbnailUrl();
                break;
            default:
                $url = $this->getMediumUrl();
                break;
        }
        return $url;
    }

}
