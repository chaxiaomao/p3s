<?php

namespace backend\modules\Statics\modules\WarehouseCommitNote\controllers;

use common\models\c2\search\WarehouseCommitDeliveryItemSearch;
use common\models\c2\search\WarehouseCommitReceiptItemSearch;
use Yii;
use common\models\c2\entity\WarehouseCommitNote;
use common\models\c2\search\WarehouseCommitNoteSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for WarehouseCommitNote model.
 */
class DefaultController extends Controller
{
    public $modelClass = 'common\models\c2\entity\WarehouseCommitNote';
    
    /**
     * Lists all WarehouseCommitNote models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WarehouseCommitNoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WarehouseCommitNote model.
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
     * create/update a WarehouseCommitNote model.
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
        
        return (Yii::$app->request->isAjax) ? $this->renderAjax('edit', [ 'model' => $model,]) : $this->render('edit', [ 'model' => $model,]);
    }
    
    /**
     * Finds the WarehouseCommitNote model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return WarehouseCommitNote the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WarehouseCommitNote::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionViewReceipts($commit_id)
    {
        $this->layout = '/main-block';
        $searchModel = new WarehouseCommitReceiptItemSearch();
        $searchModel->commit_id = $commit_id;
        // $model = WarehouseCommitNote::findOne($commit_id);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view_receipts', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            // 'model' => $model,
        ]);
    }

    public function actionViewDeliverys($commit_id)
    {
        $this->layout = '/main-block';
        $searchModel = new WarehouseCommitDeliveryItemSearch();
        $searchModel->commit_id = $commit_id;
        // $model = WarehouseCommitNote::findOne($commit_id);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view_deliverys', [
            // 'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
