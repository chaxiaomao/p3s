<?php

namespace backend\modules\Database\modules\Material\controllers;

use common\models\c2\statics\ProductType;
use Yii;
use common\models\c2\entity\Product;
use common\models\c2\search\ProductSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Default controller for the `material` module
 */
class DefaultController extends Controller
{
    public $modelClass = 'backend\models\c2\entity\Material';

    public function actions()
    {
        return \yii\helpers\ArrayHelper::merge(parent::actions(), [
            'editColumn' => [                                       // identifier for your editable action
                'formName' => 'Product',
                'class' => \backend\components\actions\EditableColumnAction::className(), // extends \kartik\grid\EditableColumnAction
                'modelClass' => $this->modelClass, // the update model class
            ],
            'translation-save' => [
                'class' => '\cza\base\components\actions\backend\TranslationSaveAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'profile-save' => [
                'class' => '\cza\base\components\actions\backend\ProfileSaveAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
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
        $searchModel->type = ProductType::TYPE_MATERIAL;
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

    /**
     * create/update a Product model.
     * fit to pajax call
     * @return mixed
     */
    public function actionEdit($id = null)
    {
        $model = $this->retrieveModel($id);
        $model->type = ProductType::TYPE_MATERIAL;
        // $model->loadWarehouse();
        $model->loadCategoryIds();

        if ($model->load(Yii::$app->request->post())) {
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
}
