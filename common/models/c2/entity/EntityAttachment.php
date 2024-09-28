<?php

namespace common\models\c2\entity;

use common\models\c2\statics\CmsBlockType;
use common\widgets\galleryManager\GalleryBehavior;
use machour\yii2\adminlte\widgets\Html;
use Yii;
use yii\base\Exception;
use yii\helpers\Url;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "{{%entity_attachment}}".
 *
 * @property string $id
 * @property string $entity_id
 * @property string $entity_class
 * @property string $entity_attribute
 * @property integer $type
 * @property string $name
 * @property string $label
 * @property string $url
 * @property string $content
 * @property string $hash
 * @property string $extension
 * @property integer $size
 * @property string $mime_type
 * @property string $logic_path
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class EntityAttachment extends \cza\base\models\ActiveRecord {

    protected $_debug = false;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%entity_attachment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['entity_id', 'type', 'size', 'status', 'position'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            // [['url'], 'url'],
            [['entity_class', 'content', 'entity_attribute', 'name', 'label', 'hash', 'extension', 'mime_type', 'logic_path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app.c2', 'ID'),
            'entity_id' => Yii::t('app.c2', 'Entity ID'),
            'entity_class' => Yii::t('app.c2', 'Entity Class'),
            'entity_attribute' => Yii::t('app.c2', 'Entity Attribute'),
            'type' => Yii::t('app.c2', 'Type'),
            'name' => Yii::t('app.c2', 'Name'),
            'label' => Yii::t('app.c2', 'Label'),
            'content' => Yii::t('app.c2', 'Content'),
            'url' => Yii::t('app.c2', 'Url'),
            'hash' => Yii::t('app.c2', 'Hash'),
            'extension' => Yii::t('app.c2', 'Extension'),
            'size' => Yii::t('app.c2', 'Size'),
            'mime_type' => Yii::t('app.c2', 'Mime Type'),
            'logic_path' => Yii::t('app.c2', 'Logic Path'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\EntityAttachmentQuery the active query used by this AR class.
     */
    public static function find() {
        return new \common\models\c2\query\EntityAttachmentQuery(get_called_class());
    }

    public function getDownloadUrl() {
        return Url::to(['/attachments/file/download', 'id' => $this->id]);
    }

    public function getHashFileName() {
        return "{$this->hash}.{$this->extension}";
    }

    public function getFileName() {
        return "{$this->name}.{$this->extension}";
    }

    public function getStoreUrl() {
        if (!isset($this->_data['storeUrl'])) {
            $this->_data['storeUrl'] = Yii::$app->params['config']['upload']['accessUrl'];
        }
        return $this->_data['storeUrl'];
    }

    public function setStoreUrl($val) {
        $this->_data['storeUrl'] = $val;
    }

    public function getStorePath() {
        if (!isset($this->_data['storePath'])) {
            $this->_data['storePath'] = Yii::$app->czaHelper->folderOrganizer->getFullUploadStorePath($this);
        }
        return $this->_data['storePath'];
    }

    public function getStoreDir() {
        if (!isset($this->_data['storeDir'])) {
            $this->_data['storeDir'] = dirname($this->getStorePath());
        }
        return $this->_data['storeDir'];
    }

    public function getLogicPath() {
        return $this->logic_path;
    }

    public function getFilelUrl() {
        if (!isset($this->_data['fileUrl'])) {
            $this->_data['fileUrl'] = $this->getStoreUrl() . '/' . $this->getLogicPath() . $this->getHashFileName();
        }
        return $this->_data['fileUrl'];
    }

    public function beforeDelete() {
        $filePath = $this->getStorePath();
        if (@\file_exists($filePath)) {
            $dir = dirname($filePath);
            FileHelper::removeDirectory($dir);
        } else {
            if ($this->_debug) {
//                throw new Exception("Can not detect {$filePath}");
            }
        }
        return parent::beforeDelete();
    }

    /**
     * for avatar preview
     * @return type
     */
    public function getInitialPreview() {
        $initialPreview = [];
        $initialPreview[] = Html::img($this->renderlink(), ['class' => 'file-preview-image', 'style' => 'width:300px;height:250px']);
        return $initialPreview;
    }

    public function renderlink() {
//        $entity = EntityAttachment::find()->andWhere(['hash'=>$this->link])->one();
        $link = Yii::$app->settings->get('url\image_base_url') . '/' . $this->logic_path . $this->hash . '.' . $this->extension;
        return $link;
    }

    public function isVideo() {
        return in_array($this->mime_type, ['video/mp4', 'video/x-msvideo', 'video/x-flv', 'video/quicktime', 'video/x-matroska',]);
    }

}
