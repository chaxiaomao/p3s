<?php

namespace backend\modules\Database\modules\Product\modules\Combination\controllers;

use common\models\c2\entity\ProductCombinationItem;
use cza\base\models\statics\ResponseDatum;
use Yii;
use common\models\c2\entity\ProductCombination;
use common\models\c2\search\ProductionCombinationSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for ProductCombination model.
 */
class DefaultController extends Controller
{
    public $modelClass = 'common\models\c2\entity\ProductCombination';

    public function actions()
    {
        return \yii\helpers\ArrayHelper::merge(parent::actions(), [
            // 'search-product' => [
            //     'class' => '\cza\base\components\actions\common\OptionsListAction',
            //     'modelClass' => \common\models\c2\entity\Product::className(),
            //     'listMethod' => 'getOptionsListCallable',
            //     'keyAttribute' => 'id',
            //     'valueAttribute' => 'name',
            //     'queryAttribute' => 'name',
            //     'checkAccess' => [$this, 'checkAccess'],
            // ],
            // 'product' => [
            //     'class' => 'common\components\actions\ProductAction',
            // ],
        ]);
    }
    
    /**
     * Lists all ProductCombination models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductionCombinationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductCombination model.
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
     * create/update a ProductCombination model.
     * fit to pajax call
     * @return mixed
     */
    public function actionEdit($id = null, $product_id = null)
    {
        $model = $this->retrieveModel($id);

        if (!is_null($product_id)) {
            $model->product_id = $product_id;
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
     * Finds the ProductCombination model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductCombination the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductCombination::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDeleteSubitem($id)
    {
        if (($model = ProductCombinationItem::findOne($id)) !== null) {
            if ($model->delete()) {
                $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!!')], $id);
            }
        }
        return $this->asJson($responseData);
    }

    public function actionMultipleDelete(array $ids)
    {
        foreach ($ids as $id) {
            if (($model = $this->retrieveModel($id)) !== null) {
                $model->delete();
            }
        }
        if (true) {
            $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $ids);
        } else {
            $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!!')], $ids);
        }
        return $this->asJson($responseData);
    }

}
