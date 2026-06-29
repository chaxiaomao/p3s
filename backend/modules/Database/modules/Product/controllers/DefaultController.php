<?php

namespace backend\modules\Database\modules\Product\controllers;

use backend\models\c2\entity\Product;
use common\models\c2\search\ProductionCombinationSearch;
use common\models\c2\statics\ProductType;
use Yii;
use common\models\c2\search\ProductSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for Product model.
 */
class DefaultController extends Controller
{
    public $modelClass = 'backend\models\c2\entity\Product';

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
                'entityClass' => \common\models\c2\entity\Product::className(),
                'entityAttribute' => 'album',
                // 'onComplete' => function ($filename, $params) {
                //     Yii::info($filename);
                //     Yii::info($params);
                // }
            ],
        ]);
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $searchModel->type = ProductType::TYPE_PRODUCT;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDetail()
    {
        $request = Yii::$app->request;
        if (!is_null($id = $request->post('id', $request->post('expandRowKey')))) {
            $searchModel = new ProductionCombinationSearch();
            $searchModel->product_id = $id;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->renderPartial('/combination/index', [
                'dataProvider' => $dataProvider,
                'productModel' => $this->retrieveModel($id),
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    /**
     * create/update a Product model.
     * fit to pajax call
     * @return mixed
     */
    public function actionEdit($id = null)
    {
        $model = $this->retrieveModel($id);
        $model->type = ProductType::TYPE_PRODUCT;
        // $model->loadWarehouse();
        $model->loadCategoryIds();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->isNewRecord) {
                if ($model->save()) {
                    return $this->redirect(['edit', 'id' => $model->id]);
                }
            }
            if ($model->save()) {
                Yii::$app->session->setFlash($model->getMessageName(), [Yii::t('app.c2', 'Saved successful.')]);
            } else {
                Yii::$app->session->setFlash($model->getMessageName(), $model->errors);
            }
        }

        return (Yii::$app->request->isAjax) ? $this->renderAjax('edit', ['model' => $model,]) : $this->render('edit', ['model' => $model,]);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
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
