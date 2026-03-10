<?php

namespace backend\modules\CL\modules\PAM\modules\ProductionSchedule\controllers;

use backend\models\c2\entity\cl\ProductionScheduleSearch;
use backend\models\c2\entity\ProductionScheduleTermination;
use common\models\c2\entity\OrderItem;
use common\models\c2\entity\ProductionConsumption;
use common\models\c2\entity\ProductionScheduleItem;
use common\models\c2\statics\ProductionScheduleState;
use common\models\c2\statics\ProductionScheduleType;
use cza\base\models\statics\ResponseDatum;
use Yii;
use common\models\c2\entity\ProductionSchedule;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for ProductionSchedule model.
 */
class DefaultController extends Controller
{
    public $modelClass = 'backend\models\c2\entity\ProductionSchedule';

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'product-addition' => [
                'class' => 'common\components\actions\ProductAdditionOptionsAction',
            ],
        ]);
    }

    /**
     * Lists all ProductionSchedule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductionScheduleSearch();
        $searchModel->type = ProductionScheduleType::PRODUCT;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductionSchedule model.
     * @param string $id
     * @return mixed
     */
    public function actionPrint($id)
    {
        $this->layout = '/print_modal';
        $query = ProductionConsumption::find()->where(['schedule_id' => $id]);
        $query->select(['*', new Expression('SUM(need_sum) as sum')]);
        $query->with('product.measure');
        $query->groupBy(['need_product_id']);
        $model = $this->retrieveModel($id);
        $model->loadItems();
        return $this->render('print', ['data' => $query->asArray()->all(), 'model' => $model]);
    }

    /**
     * create/update a ProductionSchedule model.
     * fit to pajax call
     * @return mixed
     */
    public function actionEdit($id = null)
    {
        $model = $this->retrieveModel($id);
        // $model->type = ProductionScheduleType::PRODUCT;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash($model->getMessageName(), [Yii::t('app.c2', 'Saved successful.')]);
            } else {
                Yii::$app->session->setFlash($model->getMessageName(), $model->errors);
            }
        }

        $model->loadItems();

        return (Yii::$app->request->isAjax) ? $this->renderAjax('edit', ['model' => $model,]) : $this->render('edit', ['model' => $model,]);
    }

    /**
     * create/update a ProductionSchedule model.
     * fit to pajax call
     * @return mixed
     */
    public function actionUpdate($id = null)
    {
        $model = $this->retrieveModel($id);
        // $model->type = ProductionScheduleType::PRODUCT;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash($model->getMessageName(), [Yii::t('app.c2', 'Saved successful.')]);
            } else {
                Yii::$app->session->setFlash($model->getMessageName(), $model->errors);
            }
        }

        $model->loadItems();

        return (Yii::$app->request->isAjax) ? $this->renderAjax('update', ['model' => $model,]) : $this->render('update', ['model' => $model,]);
    }

    /**
     * Finds the ProductionSchedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductionSchedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = \backend\models\c2\entity\ProductionSchedule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDeleteSubitem($id)
    {
        if (($model = ProductionScheduleItem::findOne($id)) !== null) {
            if ($model->delete()) {
                $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!!')], $id);
            }
        }
        return $this->asJson($responseData);
    }

    public function actionCommit($id)
    {
        try {
            $model = $this->retrieveModel($id);
            if ($model) {
                $model->setStateToCommit();
                $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!')], $id);
            }
        } catch (\Exception $ex) {
            $responseData = ResponseDatum::getErrorDatum(['message' => $ex->getMessage()], $id);
        }

        return $this->asJson($responseData);
    }

    public function actionCalculation($id)
    {
        try {
            $model = $this->retrieveModel($id);
            if ($model) {
                $model->setStateToCalculation();
                $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!')], $id);
            }
        } catch (\Exception $ex) {
            $responseData = ResponseDatum::getErrorDatum(['message' => $ex->getMessage()], $id);
        }

        return $this->asJson($responseData);
    }

    public function actionTermination($id = null)
    {
        // $model = ScheduleTermination::findOne($id);
        $model = new ProductionScheduleTermination();
        $model->schedule_id = $id;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash($model->getMessageName(), [Yii::t('app.c2', 'Saved successful.')]);
            } else {
                Yii::$app->session->setFlash($model->getMessageName(), $model->errors);
            }
        }

        // $model->loadItems();

        return (Yii::$app->request->isAjax) ? $this->renderAjax('termination', ['model' => $model,]) : $this->render('termination', ['model' => $model,]);
    }

    public function actionFinish($id = null)
    {
        try {
            $model = $this->retrieveModel($id);
            if ($model) {
                $model->setStateToFinish();
                $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!')], $id);
            }
        } catch (\Exception $ex) {
            $responseData = ResponseDatum::getErrorDatum(['message' => $ex->getMessage()], $id);
        }

        return $this->asJson($responseData);
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->state == ProductionScheduleState::INIT
            || $model->state == ProductionScheduleState::CALCULATION
            || $model->state == ProductionScheduleState::TERMINATION
        ) {
            if ($model->delete()) {
                $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!!')], $id);
            }
        } else {
            $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('app.c2', 'Error: operation can not finish!!')], $id);
        }
        return $this->asJson($responseData);
    }

    public function actionReceiptLog()
    {
        $searchModel = new ProductionScheduleSearch();
        $searchModel->type = ProductionScheduleType::PRODUCT;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
