<?php

namespace backend\modules\P3S\modules\Processing\modules\DeliveryNote\controllers;

use common\models\c2\statics\InventoryDeliveryNoteState;
use Yii;
use common\models\c2\entity\InventoryDeliveryNote;
use common\models\c2\search\InventoryDeliveryNoteSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `delivery-note` module
 */
class DefaultController extends Controller
{
    public $modelClass = 'common\models\c2\entity\InventoryDeliveryNote';

    /**
     * Lists all InventoryDeliveryNote models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InventoryDeliveryNoteSearch();
        $searchModel->state = InventoryDeliveryNoteState::PROCESSING;
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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
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

}
