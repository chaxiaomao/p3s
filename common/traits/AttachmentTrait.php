<?php

namespace common\traits;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use common\models\c2\entity\EntityAttachment;
use common\models\c2\entity\EntityAttachmentImage;
use common\models\c2\entity\EntityAttachmentFile;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\ImageSize;

trait AttachmentTrait {

    protected $vedioTypes = ['mp4', 'swf'];

    public function getAttachmentImage($attribute) {
        return $this->getAttachmentImages($attribute)->one();
    }

    public function getVedioAttachment($attribute = '') {
        return $this->getVedioAttachments($attribute)->one();
    }

    public function getVedioAttachments($attribute = 'files') {
        $condition = !empty($attribute) ? ['entity_class' => static::className(), 'entity_attribute' => $attribute, 'extension' => $this->vedioTypes, 'status' => EntityModelStatus::STATUS_ACTIVE] : ['extension' => $this->vedioTypes, 'entity_class' => static::className(), 'status' => EntityModelStatus::STATUS_ACTIVE];
        return $this->hasMany(EntityAttachmentFile::className(), ['entity_id' => 'id'])
                        ->andOnCondition($condition)
                        ->orderBy(['position' => SORT_DESC, 'id' => SORT_ASC]);
    }

    public function getAllAttachments() {
        $condition = ['entity_class' => static::className()];
        return $this->hasMany(EntityAttachment::className(), ['entity_id' => 'id'])
                        ->andOnCondition($condition)
                        ->orderBy(['position' => SORT_DESC, 'id' => SORT_ASC]);
    }

    public function getAttachmentImages($attribute = 'album') {
        $condition = !empty($attribute) ? ['entity_class' => static::className(), 'entity_attribute' => $attribute, 'status' => EntityModelStatus::STATUS_ACTIVE] : ['entity_class' => static::className(), 'status' => EntityModelStatus::STATUS_ACTIVE];
        return $this->hasMany(EntityAttachmentImage::className(), ['entity_id' => 'id'])
                        ->andOnCondition($condition)
                        ->orderBy(['position' => SORT_DESC, 'id' => SORT_ASC]);
    }

    public function getAttachmentFiles($attribute = 'files') {
        return $this->hasMany(EntityAttachmentFile::className(), ['entity_id' => 'id'])
                        ->andOnCondition(['entity_class' => static::className(), 'entity_attribute' => $attribute, 'status' => EntityModelStatus::STATUS_ACTIVE])
                        ->orderBy(['position' => SORT_DESC, 'id' => SORT_ASC]);
    }

    public function getThumbnailUrl($attribute = 'avatar') {
        return $this->getImageUrl($attribute, ImageSize::THUMBNAIL);
    }

    public function getIconUrl($attribute = 'avatar') {
        return $this->getImageUrl($attribute, ImageSize::ICON);
    }

    public function getMediumUrl($attribute = 'avatar') {
        return $this->getImageUrl($attribute, ImageSize::MEDIUM);
    }

    public function getOriginalUrl($attribute = 'avatar') {
        return $this->getImageUrl($attribute, ImageSize::ORGINAL);
    }

    public function getImageUrl($attribute = 'avatar', $size = ImageSize::THUMBNAIL) {
        $key = $attribute . '_' . $size;
        if (!isset($this->_data[$key])) {
            $attachment = $this->getAttachmentImage($attribute);
            $this->_data[$key] = !is_null($attachment) ? $attachment->getUrlByFormat($size) : "";
        }
        return $this->_data[$key];
    }

    public function removeImage($attribute = 'avatar') {
        $images = $this->getAttachmentImages($attribute)->all();
        foreach ($images as $item) {
            $item->delete();
        }
    }
    
    public function removeAllImages() {
        $images = $this->getAttachmentImages('')->all();
        foreach ($images as $item) {
            $item->delete();
        }
    }

}
