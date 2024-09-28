<?php

namespace backend\modules\P3S\modules\Processing\modules\ReceiptNote\controllers;

use common\models\c2\entity\InventoryReceiptNoteItem;
use common\models\c2\statics\InventoryReceiptNoteState;
use cza\base\models\statics\ResponseDatum;
use Yii;
use common\models\c2\entity\InventoryReceiptNote;
use common\models\c2\search\InventoryReceiptNoteSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
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
        $searchModel->state = InventoryReceiptNoteState::PROCESSING;
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
    public function actionView($id)
    {
        $this->layout = '/print_modal';
        return $this->render('view', [
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
}
