<?php

namespace common\components\actions\Wechat;

use Yii;
use yii\base\Action;
use yii\helpers\FileHelper;
use yii\web\HttpException;
use yii\web\Response;
use cza\base\models\statics\ResponseDatum;

/**
 * handle upload upload images as attachemnts of the entity
 * UserTempAttachmentDeleteAction class file.
 */
class UserTempAttachmentDeleteAction extends Action {

    use AttachmentUploadTrait;

    protected $_data = [];
    public $onComplete;  // callback function
    public $idAttribute = 'id';

    /**
     * @var string the directory to store temporary files during conversion. You may use path alias here.
     * If not set, it will use the "plupload" subdirectory under the application runtime path.
     */
    public $storePath = '@app/web/uploads/temp';
    public $storeUrl = '/uploads/temp';
    public $groupCode = 'wx_album';

    /**
     * Initializes the action and ensures the temp path exists.
     */
    public function init() {
        parent::init();
    }

    /**
     * Runs the action.
     * This method displays the view requested by the user.
     * @throws HttpException if the view is invalid
     */
    public function run($id) {

        $session = Yii::$app->session;
        if ($session->has($this->groupCode) && isset($session[$this->groupCode][$id])) {
            $filePath = $this->getFilePath($session[$this->groupCode][$id]);
            if (\file_exists($filePath)) {
                @unlink($filePath);
            }
            unset($session[$this->groupCode][$id]);
            $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
        } else {
            $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!!')], $id);
        }

        return $this->controller->asJson($responseData);
    }

}
