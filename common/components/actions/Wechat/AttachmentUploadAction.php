<?php

namespace common\components\actions\Wechat;

use Yii;
use yii\base\Action;
use yii\helpers\FileHelper;
use yii\web\HttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use cza\base\models\statics\ResponseDatum;

/**
 * handle upload upload images as attachemnts of the entity
 * AttachmentUploadAction class file.
 */
class AttachmentUploadAction extends \cza\base\vendor\widgets\plupload\PluploadAction {

    protected $_organizer;

    /**
     * @var string file input name.
     */
    public $inputName = 'file';

    /**
     * @var string the directory to store temporary files during conversion. You may use path alias here.
     * If not set, it will use the "plupload" subdirectory under the application runtime path.
     */
    public $tempPath = '@runtime/uploads/temp/wechat_upload';

    /**
     * @var integer the permission to be set for newly created cache files.
     * This value will be used by PHP chmod() function. No umask will be applied.
     * If not set, the permission will be determined by the current environment.
     */
    public $fileMode;

    /**
     * @var integer the permission to be set for newly created directories.
     * This value will be used by PHP chmod() function. No umask will be applied.
     * Defaults to 0775, meaning the directory is read-writable by owner and group,
     * but read-only for other users.
     */
    public $dirMode = 0775;

    /**
     * @var callable success callback with signature: `function($filename, $params)`
     */
    public $onComplete;
    public $attachementClass;
    public $enableAttachementVersions = false;
    public $entityClass;
    public $entityId = 'entity_id';
    public $entityAttribute = 'wx_album';
    public $maxSize = 10;

    /**
     * Initializes the action and ensures the temp path exists.
     */
    public function init() {
        parent::init();

        if (empty($this->attachementClass)) {
            throw new \yii\base\Exception("attachementClass is required!");
        }

        $this->_organizer = Yii::$app->czaHelper->folderOrganizer;
        Yii::$app->response->format = Response::FORMAT_JSON;

        $this->tempPath = Yii::getAlias($this->tempPath);
        if (!is_dir($this->tempPath)) {
            FileHelper::createDirectory($this->tempPath, $this->dirMode, true);
        }
    }

    /**
     * Runs the action.
     * This method displays the view requested by the user.
     * @throws HttpException if the view is invalid
     */
    public function run() {
        if (Yii::$app->wechat->isWechat) {
            $app = Yii::$app->wechat->getApp();
            $temporary = $app->material_temporary;
            $request = Yii::$app->request;
            $params = $request->post();

            if (isset($params['media_id'])) {
                $downloadPath = $this->tempPath;
                try {
                    $fileName = $temporary->download($params['media_id'], $downloadPath);
                    $filePath = $downloadPath . DIRECTORY_SEPARATOR . $fileName;
//                    Yii::info('filePath: ' . $filePath, 'debug');
                    if (@file_exists($filePath)) {
                        $fileHash = $params['media_id'];
                        $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                        $newFileName = "{$fileHash}.{$fileType}";

                        $entityClass = $this->entityClass;
                        $entityModel = $entityClass::findOne(['id' => $params[$this->entityId]]);
                        if (is_null($entityModel)) {
                            throw new \yii\base\Exception("entity model(id:{$params[$this->entityId]}) not found!");
                        }

                        $albumCount = $entityModel->getAttachmentImages($this->entityAttribute)->count();
                        if ($albumCount >= $this->maxSize) {
//                            Yii::info('albumCount： ' . $albumCount, 'debug');
                            $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('app.c2', 'Error: More Then 5 pics')], $params);
                            return $this->controller->asJson($responseData);
                        }

                        $fileDirPath = $this->_organizer->getFullUploadStoreDir($fileHash, $entityModel);
                        $newFilePath = $fileDirPath . DIRECTORY_SEPARATOR . $newFileName;
//                        Yii::info('newFilePath: ' . $newFilePath, 'debug');

                        if (!copy($filePath, $newFilePath)) {
                            throw new Exception("Cannot copy file! {$filePath}  to {$newFilePath}");
                        }
                        $attachementClass = $this->attachementClass;
                        $attachement = new $attachementClass;
                        $attachement->loadDefaultValues();
                        $attachement->setEnableVersions($this->enableAttachementVersions);

                        $attachement->setAttributes([
                            //                'name' => pathinfo($filePath, PATHINFO_FILENAME),
                            //                'type' => $attachement->type,
                            'name' => $newFileName,
                            'entity_id' => $entityModel->id,
                            'entity_class' => $this->entityClass,
                            'entity_attribute' => $this->entityAttribute,
                            'hash' => $fileHash,
                            'size' => filesize($newFilePath),
                            'content' => "",
                            'extension' => $fileType,
                            'mime_type' => FileHelper::getMimeType($newFilePath),
                            'logic_path' => $this->_organizer->getUploadLogicPath($fileHash, $entityModel),
                        ]);

                        if ($attachement->save()) {
                            @\unlink($filePath);
                        }

                        if ($this->onComplete) {
                            return call_user_func($this->onComplete, $attachement, $params);
                        } else {
                            return [
                                'filename' => $filePath,
                                'params' => $params,
                            ];
                        }
                    }
                } catch (\Exception $ex) {
                    Yii::info($ex->getMessage());
                }
            };
        }

        return null;
    }

}
