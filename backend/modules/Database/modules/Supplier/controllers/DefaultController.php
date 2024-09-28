<?php

namespace backend\modules\Database\modules\Supplier\controllers;

use Yii;
use common\models\c2\entity\Supplier;
use common\models\c2\search\SupplierSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Supplier model.
 */
class DefaultController extends Controller
{
    public $modelClass = 'common\models\c2\entity\Supplier';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'citys' => [
                'class' => 'common\components\actions\RegionOptionsAction',
            ],
            'districts' => [
                'class' => 'common\components\actions\DistricRegionOptionsAction',
            ],
        ]);
    }
    
    /**
     * Lists all Supplier models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SupplierSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Supplier model.
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
     * create/update a Supplier model.
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
     * Finds the Supplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Supplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Supplier::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
