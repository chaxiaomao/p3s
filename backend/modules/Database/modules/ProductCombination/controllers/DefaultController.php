<?php

namespace backend\modules\Database\modules\ProductCombination\controllers;

use common\models\c2\entity\OrderItem;
use common\models\c2\statics\OrderState;
use Yii;
use common\models\c2\entity\ProductCombination;
use common\models\c2\search\ProductCombinationSearch;

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
            'images-sort' => [
                'class' => \cza\base\components\actions\common\AttachmentSortAction::className(),
                'attachementClass' => \common\models\c2\entity\EntityAttachmentImage::className(),
            ],
            'images-delete' => [
                'class' => \cza\base\components\actions\common\AttachmentDeleteAction::className(),
                'attachementClass' => \common\models\c2\entity\EntityAttachmentImage::className(),
            ],
            'images-upload' => [
                'class' => \cza\base\components\actions\common\AttachmentUploadAction::className(),
                'attachementClass' => \common\models\c2\entity\EntityAttachmentImage::className(),
                'entityClass' => \common\models\c2\entity\ProductCombination::className(),
                'entityAttribute' => 'album',
                // 'onComplete' => function ($filename, $params) {
                //     Yii::info($filename);
                //     Yii::info($params);
                // }
            ],
        ]);
    }
    
    /**
     * Lists all ProductCombination models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductCombinationSearch();
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

    public function actionStockDetail()
    {
        $id = Yii::$app->request->post('expandRowKey');
        $models = OrderItem::find()
            ->alias('oi')
            ->select([
                'oi.*',
                'o.code',
                'o.state',
            ])
            ->leftJoin('c2_order o', 'o.id = oi.order_id')
            ->where([ 'combination_id' => $id])
            ->andFilterWhere(['in', 'o.state', [OrderState::PROCESSING, OrderState::INIT]])
            // ->andWhere(['oi.status' => EntityModelStatus::STATUS_ACTIVE])
            ->asArray()
            ->all();


        return $this->renderAjax('_stock', [
            'models' => $models,
        ]);
    }

    /**
     * create/update a ProductCombination model.
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

    public function actionViewAlbums($id = null)
    {
        $model = $this->retrieveModel($id);
        $this->layout = false;
        return $this->render('albums', ['model' => $model]);
    }

}
