<?php

namespace backend\modules\P3S\modules\Inventory\modules\DeliveryNote\controllers;

use common\models\c2\entity\InventoryDeliveryNoteItem;
use common\models\c2\search\WarehouseCommitDeliveryItemSearch;
use common\models\c2\statics\OrderState;
use cza\base\models\statics\ResponseDatum;
use Yii;
use common\models\c2\entity\InventoryDeliveryNote;
use common\models\c2\search\InventoryDeliveryNoteSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for InventoryDeliveryNote model.
 */
class DefaultController extends Controller
{
    public $modelClass = 'common\models\c2\entity\InventoryDeliveryNote';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'product-addition' => [
                'class' => 'common\components\actions\ProductAdditionOptionsAction',
            ],
            'orders' => [
                'class' => 'common\components\actions\OrderOptionsAction',
            ],
            'profile' => [
                'class' => 'common\components\actions\ProfileOptionsAction',
            ],
        ]);
    }
    
    /**
     * Lists all InventoryDeliveryNote models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InventoryDeliveryNoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InventoryDeliveryNote model.
     * @param string $id
     * @return mixed
     */
    public function actionView($note_id)
    {
        $this->layout = '/print_modal';
        $searchModel = new WarehouseCommitDeliveryItemSearch();
        $searchModel->note_id = $note_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = InventoryDeliveryNote::findOne($note_id);
        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * create/update a InventoryDeliveryNote model.
     * fit to pajax call
     * @return mixed
     */
    public function actionEdit($id = null) 
    {
        $model = $this->retrieveModel($id);
        
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash($model->getMessageName(), [Yii::t('app.c2', 'Saved successful.')]);
            } else {
                Yii::$app->session->setFlash($model->getMessageName(), $model->errors);
            }
        }

        $model->loadItems();
        
        return (Yii::$app->request->isAjax) ? $this->renderAjax('edit', [ 'model' => $model,]) : $this->render('edit', [ 'model' => $model,]);
    }
    
    /**
     * Finds the InventoryDeliveryNote model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return InventoryDeliveryNote the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InventoryDeliveryNote::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDeleteSubitem($id)
    {
        if (($model = InventoryDeliveryNoteItem::findOne($id)) !== null) {
            if ($model->delete()) {
                $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!!')], $id);
            }
        }
        return $this->asJson($responseData);
    }

    public function actionPrint($id)
    {
        $this->layout = '/print_modal';
        return $this->render('print', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionInit($id)
    {
        try {
            $model = $this->retrieveModel($id);
            if ($model) {
                $model->setStateToInit();
                $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!')], $id);
            }
        } catch (\Exception $ex) {
            $responseData = ResponseDatum::getErrorDatum(['message' => $ex->getMessage()], $id);
        }

        return $this->asJson($responseData);
    }

    public function actionCancel($id)
    {
        try {
            $model = $this->retrieveModel($id);
            if ($model) {
                $model->setStateToCancel();
                $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!')], $id);
            }
        } catch (\Exception $ex) {
            $responseData = ResponseDatum::getErrorDatum(['message' => $ex->getMessage()], $id);
        }

        return $this->asJson($responseData);
    }

    public function actionProcessing($id)
    {
        try {
            $model = $this->retrieveModel($id);
            if ($model) {
                $model->setStateToProcessing();
                $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!')], $id);
            }
        } catch (\Exception $ex) {
            $responseData = ResponseDatum::getErrorDatum(['message' => $ex->getMessage()], $id);
        }

        return $this->asJson($responseData);
    }

    public function actionSolved($id)
    {
        try {
            $model = $this->retrieveModel($id);
            if ($model && $model->order->state != OrderState::CANCEL) {
                if ($model->setStateToSolved()) {
                    $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
                } else {
                    $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!')], $id);
                }
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!')], $id);
            }
        } catch (\Exception $ex) {
            $responseData = ResponseDatum::getErrorDatum(['message' => $ex->getMessage()], $id);
        }

        return $this->asJson($responseData);
    }

}
