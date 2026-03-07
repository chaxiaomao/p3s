<?php

namespace backend\modules\CL\modules\Database\modules\Product\modules\Package\controllers;

use common\models\c2\entity\ProductPackageItem;
use cza\base\models\statics\ResponseDatum;
use Yii;
use common\models\c2\entity\ProductPackage;
use common\models\c2\search\ProductPackageSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for ProductPackage model.
 */
class DefaultController extends Controller
{
    public $modelClass = 'common\models\c2\entity\ProductPackage';
    
    /**
     * Lists all ProductPackage models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductPackageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductPackage model.
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
     * create/update a ProductPackage model.
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
     * Finds the ProductPackage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductPackage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductPackage::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionDeleteSubitem($id)
    {

        if (($model = ProductPackageItem::findOne($id)) !== null) {
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
