<?php

namespace backend\modules\P3S\modules\WarehouseNoteItem\controllers;

use common\models\c2\entity\InventoryReceiptNote;
use common\models\c2\statics\WarehouseNoteItemStatus;
use Yii;
use common\models\c2\entity\WarehouseNoteItem;
use common\models\c2\search\WarehouseNoteItemSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for WarehouseNoteItem model.
 */
class DefaultController extends Controller
{
    public $modelClass = 'common\models\c2\entity\WarehouseNoteItem';
    
    /**
     * Lists all WarehouseNoteItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WarehouseNoteItemSearch();
        // $searchModel->status = WarehouseNoteItemStatus::COMMIT;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $note_id = Yii::$app->request->queryParams['WarehouseNoteItemSearch']['ref_note_id'];
        $note = InventoryReceiptNote::findOne($note_id);

        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'note' => $note,
        ]);
    }
    /**
     * Lists all WarehouseNoteItem models.
     * @return mixed
     */
    public function actionLog()
    {
        $searchModel = new WarehouseNoteItemSearch();
        $dataProvider = $searchModel->searchLog(Yii::$app->request->queryParams);

        return $this->render('log', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WarehouseNoteItem model.
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
     * create/update a WarehouseNoteItem model.
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
     * Finds the WarehouseNoteItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return WarehouseNoteItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WarehouseNoteItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
