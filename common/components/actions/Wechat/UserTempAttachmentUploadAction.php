<?php

namespace common\components\actions\Wechat;

use Yii;
use yii\base\Action;
use yii\helpers\FileHelper;
use yii\web\HttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use cza\base\models\statics\ResponseDatum;
use yii\helpers\Url;

/**
 * handle user temporary upload 
 * AttachmentUploadAction class file.
 */
class UserTempAttachmentUploadAction extends \cza\base\vendor\widgets\plupload\PluploadAction {

    use AttachmentUploadTrait;

    protected $_organizer;
    protected $_data = [];

    /**
     * @var string file input name.
     */
    public $inputName = 'file';

    /**
     * @var string the directory to store temporary files during conversion. You may use path alias here.
     * If not set, it will use the "plupload" subdirectory under the application runtime path.
     */
    public $storePath = '@app/web/uploads/temp';
    public $storeUrl = '/uploads/temp';

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
    public $onComplete;  // callback function
    public $groupCode = 'wx_album';
    public $maxSize = 10;

    /**
     * Initializes the action and ensures the temp path exists.
     */
    public function init() {
        parent::init();

        $this->_organizer = Yii::$app->czaHelper->folderOrganizer;
        Yii::$app->response->format = Response::FORMAT_JSON;
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
                $downloadPath = $this->getFullStorePath();
                
                Yii::info($downloadPath, 'debug');
                try {
                    $fileName = $temporary->download($params['media_id'], $downloadPath);
                    $filePath = $downloadPath . DIRECTORY_SEPARATOR . $fileName;

                    $session = Yii::$app->session;
                    if (!$session->has($this->groupCode)) {
                        $session[$this->groupCode] = new \ArrayObject;
                    } else {
                        $albumCount = count($session[$this->groupCode]);
                        if ($albumCount >= $this->maxSize) {
                            $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('app.c2', 'Error: More Then 5 pics')], $params);
                            return $this->controller->asJson($responseData);
                        }
                    }

                    $mediaUrl = $this->getFileUrl($fileName);
                    $session[$this->groupCode][$params['media_id']] = $fileName;

                    if ($this->onComplete) {
                        return call_user_func($this->onComplete, $mediaUrl, $params);
                    } else {
                        return [
                            'media_url' => $mediaUrl,
                            'params' => $params,
                        ];
                    }
                } catch (\Exception $ex) {
                    Yii::info($ex->getMessage());
                }
            };
        }

        return null;
    }

}
