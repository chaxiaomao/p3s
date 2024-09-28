<?php

namespace backend\modules\Sys\modules\Config\controllers;

use common\helpers\FeUserTransferHelper;
use common\models\c2\statics\TransferType;
use Yii;
use common\models\c2\entity\Config;
use common\models\c2\search\Config as ConfigSearch;
use cza\base\components\controllers\backend\ModelController as Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use cza\base\behaviors\CmsMediaBehavior;
use cza\base\models\statics\ResponseDatum;

/**
 * DefaultController implements the CRUD actions for Config model.
 */
class DefaultController extends Controller {

    public $modelClass = 'common\models\c2\entity\Config';
    
//    public function actions() {
//        return \yii\helpers\ArrayHelper::merge(parent::actions(), [
//                    'dyn-qrcode-generate' => [
//                        'class' => '\backend\components\actions\DynQrcodeGenerateAction',
//                        'modelClass' => \common\models\c2\entity\Config::className(),
//                        'ownerRelationship' => 'user',
//                        'view' => 'edit',
//                        'checkAccess' => [$this, 'checkAccess'],
//                    ],
//        ]);
//    }

    /**
     * Lists all Config models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ConfigSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'model' => $this->retrieveModel(),
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Config model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * create/update a Config model.
     * fit to pajax call
     * @return mixed
     */
    public function actionParamsSettings($params = []) {
        return $this->render('params_settings', []);
    }

    public function actionParamsSave() {
        $view = 'params_settings';
        $params = Yii::$app->request->post();
        if (!isset($params['modelClass'])) {
            throw new HttpException(404, Yii::t('cza', 'modelClass is required!!'));
        }
        $modelClass = $params['modelClass'];
        $model = new $modelClass;
        if ($model->load($params) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->session->setFlash($model->getMessageName(), [Yii::t('app.c2', 'Saved successful.')]);
            } else {
                Yii::$app->session->setFlash($model->getMessageName(), $model->errors);
            }
        } else {
            $errors = $model->errors;
            $errors['error'] = 'true';
//            Yii::info($errors);
            Yii::$app->session->setFlash($model->getMessageName(), $errors);
        }
        return (Yii::$app->request->isAjax) ? $this->renderAjax($view, ['model' => $model,]) : $this->render($view, ['model' => $model,]);
    }

    public function actionParamsGeoSave() {
        $view = 'params_settings';
        $params = Yii::$app->request->post();
        if (!isset($params['modelClass'])) {
            throw new HttpException(404, Yii::t('cza', 'modelClass is required!!'));
        }
        $modelClass = $params['modelClass'];
        $model = new $modelClass;
        if ($model->load($params)) {
            if ($model->save()) {
                Yii::$app->session->setFlash($model->getMessageName(), [Yii::t('app.c2', 'Saved successful.')]);
            } else {
                Yii::$app->session->setFlash($model->getMessageName(), $model->errors);
            }
        }
        $result = ResponseDatum::getSuccessDatum([
                    'message' => Yii::t('app.c2', 'Operation Success!')
        ]);
        $this->asJson($result);
    }

    public function actionTransferSettings($params = []){
        return $this->render('transfer_settings', []);
    }

    public function actionTransferSave(){
        $view = 'transfer_settings';
        $params = Yii::$app->request->post();
        if (!isset($params['modelClass'])) {
            throw new HttpException(404, Yii::t('cza', 'modelClass is required!!'));
        }
        $modelClass = $params['modelClass'];
        $model = new $modelClass;
//        $model->loadDefaultValues();
        $params['transferType']= (int)$params['transferType'];
        if($model->load($params)){
            if(FeUserTransferHelper::RelationshipTransfer($model,$params['transferType'])){
                Yii::$app->session->setFlash($model->getMessageName(), [Yii::t('app.c2', 'Saved successful.')]);
            }else{
                if(is_array($model->errors)){
                    foreach ($model->errors as $errors){
                        Yii::$app->session->setFlash($model->getMessageName(), $errors);
                    }
                }else{
                    Yii::$app->session->setFlash($model->getMessageName(), $model->errors);
                }
            }

        }
        return (Yii::$app->request->isAjax) ? $this->renderAjax($view, ['model' => $model,]) : $this->render($view, ['model' => $model,]);
    }

    /**
     * create/update a Config model.
     * fit to pajax call
     * @return mixed
     */
    public function actionEdit($id = null) {
        $model = $this->retrieveModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash($model->getMessageName(), [Yii::t('app.c2', 'Saved successful.')]);
            } else {
                Yii::$app->session->setFlash($model->getMessageName(), $model->errors);
            }
        }

        return (Yii::$app->request->isAjax) ? $this->renderAjax('edit', ['model' => $model,]) : $this->render('edit', ['model' => $model,]);
    }

    /**
     * Finds the Config model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Config the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Config::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionQrcodeGenerate() {
        $params = Yii::$app->request->post();
        if (!isset($params['imageAttribute'])) {
            throw new HttpException("Misssing imageAttribute!");
        }

        $model = new \backend\models\c2\form\Config\WechatSettingsForm();
        $model->id = $model->getEntityAttributeId($params['imageAttribute']);
        $model->generateQrCode($params);

        return (Yii::$app->request->isAjax) ? $this->renderAjax('params_settings', []) : $this->render('params_settings', []);
    }

    public function actionRefresh() {
        try {
            $sign = Yii::$app->request->post('sign');
//            $result = ResponseDatum::getSuccessDatum(['message' => Yii::t('app.c2', 'Operation Success!')]);

            switch ($sign) {
                case 'CRM':
                    $dir = Yii::getAlias('@frontend/runtime/cache');
                    $cache = new \yii\caching\FileCache(['cachePath' => '@frontend/runtime/cache']);
                    $cache->gc(true, false);
                    break;
                case 'Eshop':
                    $dir = Yii::getAlias('@app_eshop/runtime/cache');
                    $cache = new \yii\caching\FileCache(['cachePath' => '@app_eshop/runtime/cache']);
                    $cache->gc(true, false);
                    break;
                case 'Backend':
                    $dir = Yii::getAlias('@backend/runtime/cache');
                    $cache = new \yii\caching\FileCache(['cachePath' => '@backend/runtime/cache']);
                    $cache->gc(true, false);
                    break;
                case 'Console':
                    $dir = Yii::getAlias('@console/runtime/cache');
                    $cache = new \yii\caching\FileCache(['cachePath' => '@console/runtime/cache']);
                    $cache->gc(true, false);
                    break;
            }

            if ($sign == 'All') {
                $dirs[] = Yii::getAlias('@frontend/runtime/cache');
                $dirs[] = Yii::getAlias('@app_eshop/runtime/cache');
                $dirs[] = Yii::getAlias('@backend/runtime/cache');
                $dirs[] = Yii::getAlias('@console/runtime/cache');

                $cachePaths[] = '@frontend/runtime/cache';
                $cachePaths[] = '@app_eshop/runtime/cache';
                $cachePaths[] = '@backend/runtime/cache';
                $cachePaths[] = '@console/runtime/cache';
                foreach ($cachePaths as $cachePath) {
                    $cache = new \yii\caching\FileCache(['cachePath' => $cachePath]);
                    $cache->gc(true, false);
                }

                foreach ($dirs as $dir) {
                    if ($dh = opendir($dir)){
                        $i = 0;
                        while($file = readdir($dh)) {
                            $i++;
                        }
                        closedir($dh);
                        if ($i>2) {
                            $result = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!')], $sign);
                        } else {
                            $result = ResponseDatum::getSuccessDatum(['message' => Yii::t('app.c2', 'Operation Success!')], $sign);
                        }
                    }
                }
            }


            if ($dh = opendir($dir)){
                $i = 0;
                while($file = readdir($dh)) {
                    $i++;
                }
                closedir($dh);
                if ($i>2) {
                    $result = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!')], $sign);
                } else {
                    $result = ResponseDatum::getSuccessDatum(['message' => Yii::t('app.c2', 'Operation Success!')], $sign);
                }
            }
        } catch (\Exception $ex) {
            $result = ResponseDatum::getErrorDatum(['message' => $ex->getMessage()]);
        }
        
        $this->asJson($result);
    }
}
