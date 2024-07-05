<?php

namespace backend\modules\P3S\modules\Order\modules\OrderItemConsumption\controllers;

use Yii;
use common\models\c2\entity\OrderItemConsumption;
use common\models\c2\search\OrderItemConsumptionSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for OrderItemConsumption model.
 */
class DefaultController extends Controller
{
    public $modelClass = 'common\models\c2\entity\OrderItemConsumption';
    
    /**
     * Lists all OrderItemConsumption models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new OrderItemConsumptionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStats()
    {
        $this->layout = '/main-block';
        $request = Yii::$app->request;
        $id = $request->post('expandRowKey');
        $searchModel = new OrderItemConsumptionSearch();
        $searchModel->order_item_id = $id;
        $dataProvider = $searchModel->search($request->queryParams);
        return $this->render('index_detail', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrderItemConsumption model.
     * @param string $id
     * @return mixed
     */
    public function actionView()
    {
        $this->layout = '/main-block';
        $searchModel = new OrderItemConsumptionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * create/update a OrderItemConsumption model.
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
     * Finds the OrderItemConsumption model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return OrderItemConsumption the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrderItemConsumption::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
