<?php

/**
 * Created by PhpStorm.
 * User: Алимжан
 * Date: 27.01.2015
 * Time: 12:24
 */

namespace common\components\actions\Wechat;

use Yii;
use cza\base\modules\Attachments\ModuleTrait;
use cza\base\models\ActiveRecord;
use yii\base\Behavior;
use yii\base\UnknownPropertyException;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use yii\base\Exception;
use cza\base\models\statics\ImageSize;

class UserAttachmentBehavior extends \cza\base\modules\Attachments\behaviors\AttachmentBehavior {

    use AttachmentUploadTrait;

    protected $_data = [];
    protected $_refAttribues = [];
    protected $_organizer;
    public $storePath = '@app/web/uploads/temp';

    /*
     * accept attributes to class map, determine to crud related attachments
     * array, for example:
     * 'photos' => [
      'class' => EntityAttachmentImage::className(),
      'validator' => 'image',
      'enableVersions' => false,
      'rules' => [
      'maxFiles' => 5,
      'extensions' => Yii::$app->params['config']['upload']['imageWhiteExts'],
      'maxSize' => Yii::$app->params['config']['upload']['maxFileSize'],
      ]
      ],
     * 
     */
    public $attributesDefinition = [];

    public function init() {
        parent::init();
    }

    public function events() {
        return [
//            ActiveRecord::EVENT_BEFORE_VALIDATE => 'applyRules',
            ActiveRecord::EVENT_AFTER_INSERT => 'saveUploads',
            ActiveRecord::EVENT_AFTER_UPDATE => 'saveUploads',
            ActiveRecord::EVENT_AFTER_DELETE => 'deleteUploads'
        ];
    }

    public function saveUploads($event) {
        $session = Yii::$app->session;
        $refAttributes = array_keys($this->_refAttribues);
        foreach ($refAttributes as $refAttribute) {

            if ($session->has($refAttribute)) {
                $items = $session[$refAttribute];
                if (!empty($items)) {
                    foreach ($items as $k => $v) {
                        $file = $this->getFilePath($v);
                        if (!$this->attachFile($file, $refAttribute, ['hash' => $k])) {
                            throw new \Exception(\Yii::t('yii', 'File upload failed.'));
                        }
                    }
                }
                unset($session[$refAttribute]);
            }
        }
        /* cannot delete tmp dir, bcz it will affect realted model's images generation */
//        if (\file_exists($userTempDir)) {
//            \rmdir($userTempDir);
//        }
    }

    /**
     * @param $filePath string
     * @param $owner
     * @return bool|File
     * @throws Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function attachFile($filePath, $attribute, $extras = []) {
        $owner = $this->owner;
        if (empty($owner->id)) {
            throw new Exception('Parent model must have ID when you attaching a file');
        }
        if (!\file_exists($filePath)) {
            throw new Exception("File {$filePath} not exists");
        }

        $fileHash = $extras['hash'];
        $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $newFileName = "{$fileHash}.{$fileType}";

        $fileDirPath = $this->getModule()->getFileDirPath($fileHash, $owner);
        $newFilePath = $fileDirPath . DIRECTORY_SEPARATOR . $newFileName;

        if (!copy($filePath, $newFilePath)) {
            throw new Exception("Cannot copy file! {$filePath}  to {$newFilePath}");
        }
        $file = new $this->attributesDefinition[$attribute]['class'];
        if (isset($this->attributesDefinition[$attribute]['enableVersions'])) {
            $file->setEnableVersions($this->attributesDefinition[$attribute]['enableVersions']);
        }

        $file->loadDefaultValues();
        $file->setAttributes([
            'name' => pathinfo($filePath, PATHINFO_FILENAME),
            'entity_id' => $owner->id,
            'entity_class' => $owner->className(),
            'entity_attribute' => $attribute,
            'hash' => $fileHash,
            'size' => filesize($filePath),
            'content' => isset($extras['content']) ? $extras['content'] : "",
            'extension' => $fileType,
            'mime_type' => FileHelper::getMimeType($filePath),
            'logic_path' => $this->getModule()->getFileLogicPath($fileHash, $owner),
        ]);

        if ($file->save()) {
            @\unlink($filePath);
            return $file;
        } else {
            return false;
        }
    }

}
