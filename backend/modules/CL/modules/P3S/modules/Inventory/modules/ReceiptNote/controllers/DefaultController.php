<?php

namespace backend\modules\CL\modules\P3S\modules\Inventory\modules\ReceiptNote\controllers;

use backend\models\c2\entity\cl\InventoryReceiptNoteSearch;
use common\models\c2\entity\InventoryReceiptNoteItem;
use cza\base\models\statics\ResponseDatum;
use Yii;
use common\models\c2\entity\InventoryReceiptNote;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `receipt-note` module
 */
class DefaultController extends Controller
{
    public $modelClass = 'common\models\c2\entity\InventoryReceiptNote';

    /**
     * Lists all InventoryReceiptNote models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InventoryReceiptNoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InventoryReceiptNote model.
     * @param string $id
     * @return mixed
     */
    public function actionView($ref_note_id = null)
    {
        $this->layout = '/main-block';
        $note = InventoryReceiptNote::findOne($ref_note_id);
        $noteItems = $note->getWarehouseNoteItemsLog();
        return $this->render('check', [
            'note' => $note,
            // 'model' => $model,
            'noteItems' => $noteItems,
        ]);
    }

    public function actionPrint($id)
    {
        $this->layout = '/print_modal';
        return $this->render('print', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * create/update a InventoryReceiptNote model.
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
     * Finds the InventoryReceiptNote model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return InventoryReceiptNote the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InventoryReceiptNote::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDeleteSubitem($id)
    {
        if (($model = InventoryReceiptNoteItem::findOne($id)) !== null) {
            if ($model->delete()) {
                $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!!')], $id);
            }
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
            if ($model) {
                $model->setStateToSolved();
                $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!')], $id);
            }
        } catch (\Exception $ex) {
            $responseData = ResponseDatum::getErrorDatum(['message' => $ex->getMessage()], $id);
        }

        return $this->asJson($responseData);
    }
}
