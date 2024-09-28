<?php

namespace backend\modules\Logistics\modules\Region\controllers;

use common\models\c2\entity\RegionCity;
use common\models\c2\search\Region;
use common\models\c2\statics\RegionType;
use Yii;

use common\models\c2\search\Region as RegionSearch;
use common\models\c2\search\RegionCity as RegionCitySearch;
use common\models\c2\search\RegionProvince as RegionProvinceSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Region model.
 */
class DefaultController extends Controller
{
    public $modelClass = 'common\models\c2\entity\Region';

    /**
     * Lists all Region models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegionSearch();
        $searchModel2 = new RegionSearch();
        
        $cityModel = new RegionCity();
        $cityModel->type = RegionType::TYPE_CITY;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,RegionType::TYPE_PROVINCE);
        $cityDataProvider = $searchModel->search(Yii::$app->request->queryParams,RegionType::TYPE_CITY);
        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'cityModel' => $cityModel,
            'searchModel' => $searchModel,
            'searchModel2' => $searchModel2,
            'dataProvider' => $dataProvider,
            'cityDataProvider' => $cityDataProvider,
        ]);
    }

    /**
     * Displays a single Region model.
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
     * create/update a Region model.
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
     * Finds the Region model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Region the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Region::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
