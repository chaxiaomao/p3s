<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/19
 * Time: 10:14
 */

namespace common\components\actions;

use common\rest\statics\ResponseDatum;
use Yii;
use yii\helpers\FileHelper;
use yii\web\HttpException;
use yii\web\UploadedFile;
use cza\base\vendor\widgets\plupload\ChunkUploader;

class Base64ImageUploadAction extends \cza\base\components\actions\common\AttachmentUploadAction
{
    public $entityId = 'entity_id';

    public $maxSize = '10';

    public $params = [];

    public $isOnly = false;
    /**
     * Runs the action.
     * This method displays the view requested by the user.
     * @throws HttpException if the view is invalid
     */
    public function run() {
        if(empty($this->params)){
            $params = Yii::$app->request->getBodyParams();
        }else{
            $params = $this->params;
        }
        $newFilePathArr = [];

        if(count($params['images']) > $this->maxSize ){
            $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('app.c2', "Error: More Then {$this->maxSize} pics")], $params);
            return $this->controller->asJson($responseData);
        }

        if($this->isOnly){
            $attachementClass = $this->attachementClass;
            $attributor = [
                'entity_class'=>$this->entityClass,
                'entity_id'=>$params[$this->entityId],
                'entity_attribute'=>$this->entityAttribute,
            ];
            $attachementModel = $attachementClass::findAll($attributor);
            if(!empty($attachementModel)){
               foreach ($attachementModel as $item){
                   if($item){
                       $item->beforeDelete();
                       $item->delete();
                   }
               }
            }
        }

        foreach($params['images'] as $item => $image){
            $uploadedFile = $this->makeTempFile($image['base64_image']);
            $filePath = $this->getUnusedPath($this->tempPath . DIRECTORY_SEPARATOR . $uploadedFile->name);
            $isUploadComplete = ChunkUploader::process($uploadedFile, $filePath);
            if ($isUploadComplete) {
                $fileHash = md5(microtime(true) . $filePath);
                $fileType = isset($image['name']) ? strtolower(substr(stristr($image['name'], '.'), 1)) : strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                $newFileName = "{$fileHash}.{$fileType}";
                $entityClass = $this->entityClass;
                $entityModel = $entityClass::findOne(['id' => $params[$this->entityId]]);
                if (is_null($entityModel)) {
                    throw new \yii\base\Exception("entity model(id:{$params[$this->entityId]}) not found!");
                }

                $fileDirPath = $this->_organizer->getFullUploadStoreDir($fileHash, $entityModel);
                $newFilePath = $fileDirPath . DIRECTORY_SEPARATOR . $newFileName;

                if (!copy($filePath, $newFilePath)) {
                    throw new \Exception("Cannot copy file! {$filePath}  to {$newFilePath}");
                }
                $attachementClass = $this->attachementClass;
                $attachement = new $attachementClass;
                $attachement->loadDefaultValues();
                $attachement->setAttributes([
//                'name' => pathinfo($filePath, PATHINFO_FILENAME),
//                'type' => $attachement->type,
                    'name' => $image['name'],
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
                    $newFilePathArr[$item] = $newFilePath;
                }

            }
        }
        if ($this->onComplete) {
            return call_user_func($this->onComplete, $newFilePathArr, $params);
        } else {
            return [
                'filename' => $newFilePathArr,
                'params' => $params,
            ];
        }

        return null;
    }

    public function makeTempFile($attribute){
//        if (!$this->hasFileValue($attribute)) {
//            return false;
//        }
        $tempName = tempnam(sys_get_temp_dir(), 'ub_');
            if(preg_match('/^data:([\w\/]+);base64/i', $attribute, $matches)){
            list($type, $data) = explode(';', $attribute);
            list(, $data)      = explode(',', $attribute);
            $data = base64_decode($data);

            $name = uniqid('ub_');

            if (!empty($matches[1])) {
                $extensions = FileHelper::getExtensionsByMimeType($matches[1]);
                $name .= '.' . end($extensions);
            }

            if (!file_put_contents($tempName, $data)) {
                return false;
            }
        } else {
            return false;
        }

        return new UploadedFile([
            'name' => $name,
            'type' => $type,
            'tempName' => $tempName
        ]);
    }

    public function getFileValue($attribute)
    {
        if ($this->hasFileValue($attribute)) {
            return $this->_values[$attribute];
        }

        return null;
    }

    public function hasFileValue($attribute)
    {
        return !empty($this->_values[$attribute]);
    }

}