<?php

namespace common\components\actions;

use Yii;
use yii\base\Action;
use yii\helpers\FileHelper;
use yii\web\HttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use cza\base\vendor\widgets\plupload\ChunkUploader;

/**
 * handle upload upload images as attachemnts of the entity
 * EditableColumnUploadAction class file.
 */
class EditableColumnUploadAction extends \cza\base\components\actions\common\AttachmentUploadAction {

    public $entityIdKey = 'entity_id';

    /**
     * Runs the action.
     * This method displays the view requested by the user.
     * @throws HttpException if the view is invalid
     */
    public function run() {
        $params = Yii::$app->request->getBodyParams();

        if (!isset($params['editableIndex'])) {
            throw new \yii\web\HttpException("Missing editableIndex parameter!");
        }

        $paramName = "{$this->inputName}[{$params['editableIndex']}][{$this->entityAttribute}]";
        $uploadedFile = UploadedFile::getInstanceByName($paramName);
        if (is_null($uploadedFile)) {
            return [];
        }

        $filePath = $this->getUnusedPath($this->tempPath . DIRECTORY_SEPARATOR . $uploadedFile->name);
        $isUploadComplete = ChunkUploader::process($uploadedFile, $filePath);

        if ($isUploadComplete) {
            $fileHash = md5(microtime(true) . $filePath);
            $fileType = isset($params['name']) ? strtolower(substr(stristr($params['name'], '.'), 1)) : strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $newFileName = "{$fileHash}.{$fileType}";

            $entityClass = $this->entityClass;
            $entityModel = $entityClass::findOne(['id' => $params[$this->entityIdKey]]);
            if (is_null($entityModel)) {
                throw new \yii\base\Exception("entity model(id:{$params[$this->entityIdKey]}) not found!");
            }
            $entityModel->removeImage($this->entityAttribute);

            $fileDirPath = $this->_organizer->getFullUploadStoreDir($fileHash, $entityModel);
            $newFilePath = $fileDirPath . DIRECTORY_SEPARATOR . $newFileName;

            if (!copy($filePath, $newFilePath)) {
                throw new Exception("Cannot copy file! {$filePath}  to {$newFilePath}");
            }
            $attachementClass = $this->attachementClass;
            $attachement = new $attachementClass;
            $attachement->loadDefaultValues();
            $attachement->setAttributes([
//                'name' => pathinfo($filePath, PATHINFO_FILENAME),
//                'type' => $attachement->type,
                'name' => $uploadedFile->name,
                'entity_id' => $entityModel->id,
                'entity_class' => $this->entityClass,
                'entity_attribute' => $this->entityAttribute,
                'hash' => $fileHash,
                'size' => filesize($filePath),
                'content' => isset($extras['content']) ? $extras['content'] : "",
                'extension' => $fileType,
                'mime_type' => FileHelper::getMimeType($filePath),
                'logic_path' => $this->_organizer->getUploadLogicPath($fileHash, $entityModel),
            ]);

            if ($attachement->save()) {
                @\unlink($filePath);
            }

            if ($this->onComplete) {
                return call_user_func($this->onComplete, $entityModel, $attachement->name, $params);
            } else {
                return [
                    'filename' => $filePath,
                    'params' => $params,
                ];
            }
        }

        return null;
    }

}
