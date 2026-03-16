<?php

namespace backend\modules\CL\modules\P3S\modules\WarehouseNote\controllers;

use common\models\c2\entity\InventoryReceiptNote;
use common\models\c2\entity\ProductionSchedule;
use common\models\c2\statics\WarehouseNoteType;
use cza\base\models\statics\ResponseDatum;
use Yii;
use common\models\c2\entity\WarehouseNote;
use common\models\c2\search\WarehouseNoteSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for WarehouseNote model.
 */
class ProductionController extends Controller
{
    public $modelClass = 'common\models\c2\entity\WarehouseNote';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'product-addition' => [
                'class' => 'common\components\actions\ProductAdditionOptionsAction',
            ],
        ]);
    }
    
    /**
     * Lists all WarehouseNote models.
     * @return mixed
     */
    public function actionIndex($id = null)
    {
        $searchModel = new WarehouseNoteSearch();
        $searchModel->type = WarehouseNoteType::PRODUCTION;
        $searchModel->ref_note_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $note = ProductionSchedule::findOne($id);

        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'note' => $note,
        ]);
    }

    /**
     * Displays a single WarehouseNote model.
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
     * create/update a WarehouseNote model.
     * fit to pajax call
     * @return mixed
     */
    public function actionEdit($id = null, $ref_note_id = null)
    {
        $model = $this->retrieveModel($id);
        $model->type = WarehouseNoteType::PRODUCTION;
        $model->ref_note_id = $ref_note_id;
        $node = ProductionSchedule::findOne($ref_note_id);
        $model->ref_note_code = $node->code;
        
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
     * Finds the WarehouseNote model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return WarehouseNote the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WarehouseNote::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCommit($id)
    {
        try {
            $model = $this->retrieveModel($id);
            if ($model) {
                $model->setProductionScheduleNoteToCommit();
                $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!')], $id);
            }
        } catch (\Exception $ex) {
            $responseData = ResponseDatum::getErrorDatum(['message' => $ex->getMessage()], $id);
        }

        return $this->asJson($responseData);
    }

    public function actionAllEnter($id)
    {
        try {
            $model = ProductionSchedule::findOne($id);
            if ($model) {
                $model->allProductionEnter();
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
