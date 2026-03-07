<?php

namespace backend\modules\P3S\modules\Warehouse\modules\CommitNote\controllers;

use backend\models\c2\entity\WarehouseCommitDeliveryNote;
use backend\models\c2\entity\WarehouseCommitReceiptNote;
use common\models\c2\entity\InventoryDeliveryNote;
use common\models\c2\entity\InventoryReceiptNote;
use common\models\c2\entity\WarehouseCommitReceiptItem;
use common\models\c2\search\WarehouseCommitDeliveryItemSearch;
use common\models\c2\search\WarehouseCommitReceiptItemSearch;
use common\models\c2\statics\InventoryDeliveryNoteState;
use common\models\c2\statics\InventoryReceiptNoteState;
use common\models\c2\statics\WarehouseCommitNoteType;
use cza\base\models\statics\ResponseDatum;
use Yii;
use common\models\c2\entity\WarehouseCommitNote;
use common\models\c2\search\WarehouseCommitNoteSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for WarehouseCommitNote model.
 */
class DeliveryController extends Controller
{
    public $modelClass = 'backend\models\c2\entity\WarehouseCommitDeliveryNote';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'product-addition' => [
                'class' => 'common\components\actions\ProductAdditionOptionsAction',
            ],
        ]);
    }
    
    /**
     * Lists all WarehouseCommitNote models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WarehouseCommitNoteSearch();
        $queryParams = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($queryParams);
        $note_id = $queryParams['WarehouseCommitNoteSearch']['note_id'];
        $deliveryNote = InventoryDeliveryNote::findOne($note_id);
        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'deliveryNote' => $deliveryNote,
        ]);
    }

    /**
     * Displays a single WarehouseCommitNote model.
     * @param string $commit_id
     * @return mixed
     */
    public function actionView($commit_id)
    {
        $this->layout = '/main-block';
        $searchModel = new WarehouseCommitDeliveryItemSearch();
        $searchModel->commit_id = $commit_id;
        $model = WarehouseCommitNote::findOne($commit_id);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * create/update a WarehouseCommitNote model.
     * fit to pajax call
     * @return mixed
     */
    public function actionEdit($id = null, $note_id = null)
    {
        $model = $this->retrieveModel($id);
        $model->type = WarehouseCommitNoteType::TYPE_DELIVERY;
        if (!is_null($note_id)) {
            $model->note_id = $note_id;
        }
        
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
     * Finds the WarehouseCommitNote model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return WarehouseCommitDeliveryNote the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WarehouseCommitDeliveryNote::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionCommit($id, $note_id)
    {
        try {
            $model = $this->retrieveModel($id);
            $note = InventoryDeliveryNote::findOne($note_id);
            if ($model && $note->state == InventoryDeliveryNoteState::PROCESSING) {
                if ($model->setStateToCommit()) {
                    $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
                } else {
                    $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('app.c2', 'Data errors.')], $id);
                }
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('app.c2', 'Note has been cancel or not exist.')], $id);
            }
        } catch (\Exception $ex) {
            $responseData = ResponseDatum::getErrorDatum(['message' => $ex->getMessage()], $id);
        }

        return $this->asJson($responseData);
    }

    public function actionDeleteSubitem($id)
    {
        if (($model = WarehouseCommitReceiptItem::findOne($id)) !== null) {
            if ($model->delete()) {
                $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!!')], $id);
            }
        }
        return $this->asJson($responseData);
    }

    public function actionCommitForm($id = null, $note_id)
    {
        $model = $this->retrieveModel($id);
        $model->type = WarehouseCommitNoteType::TYPE_DELIVERY;
        if (!is_null($note_id)) {
            $model->note_id = $note_id;
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash($model->getMessageName(), [Yii::t('app.c2', 'Saved successful.')]);
            } else {
                Yii::$app->session->setFlash($model->getMessageName(), $model->errors);
            }
        }

        $model->loadItems();

        return (Yii::$app->request->isAjax) ? $this->renderAjax('commit_form', [ 'model' => $model,]) : $this->render('commit_form', [ 'model' => $model,]);
    }

}
