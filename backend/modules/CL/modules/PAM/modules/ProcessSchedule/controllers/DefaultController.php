<?php

namespace backend\modules\CL\modules\PAM\modules\ProcessSchedule\controllers;

use backend\models\c2\entity\MixtureScheduleTermination;
use backend\models\c2\entity\ProcessSchedule;
use common\models\c2\entity\OrderItem;
use common\models\c2\entity\ProductionScheduleItem;
use common\models\c2\statics\ProductionScheduleState;
use common\models\c2\statics\ProductionScheduleType;
use cza\base\models\statics\ResponseDatum;
use Yii;
use backend\models\c2\entity\MixtureSchedule;
use common\models\c2\search\ProductionScheduleSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `process-schedule` module
 */
class DefaultController extends Controller
{
    public $modelClass = 'backend\models\c2\entity\ProcessSchedule';

    /**
     * Lists all MixtureSchedule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductionScheduleSearch();
        $searchModel->type = ProductionScheduleType::PROCESS;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MixtureSchedule model.
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
     * create/update a MixtureSchedule model.
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

        $model->loadItems();

        return (Yii::$app->request->isAjax) ? $this->renderAjax('edit', [ 'model' => $model,]) : $this->render('edit', [ 'model' => $model,]);
    }

    /**
     * Finds the MixtureSchedule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProcessSchedule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProcessSchedule::findOne($id)) !== null) {
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

    public function actionFinish($id)
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

    // public function actionTermination($id = null)
    // {
    //     // $model = ScheduleTermination::findOne($id);
    //     $model = new MixtureScheduleTermination();
    //     $model->schedule_id = $id;
    //
    //     if ($model->load(Yii::$app->request->post())) {
    //         if ($model->save()) {
    //             Yii::$app->session->setFlash($model->getMessageName(), [Yii::t('app.c2', 'Saved successful.')]);
    //         } else {
    //             Yii::$app->session->setFlash($model->getMessageName(), $model->errors);
    //         }
    //     }
    //
    //     // $model->loadItems();
    //
    //     return (Yii::$app->request->isAjax) ? $this->renderAjax('termination', [ 'model' => $model,]) : $this->render('termination', [ 'model' => $model,]);
    // }

    public function actionTermination($id = null)
    {
        try {
            $model = $this->retrieveModel($id);
            if ($model) {
                $model->setStateToTermination();
                $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!')], $id);
            }
        } catch (\Exception $ex) {
            $responseData = ResponseDatum::getErrorDatum(['message' => $ex->getMessage()], $id);
        }

        return $this->asJson($responseData);
    }

    public function actionDelete($id) {
        $model = $this->findModel($id);
        if ($model->state == ProductionScheduleState::TERMINATION || $model->state == ProductionScheduleState::INIT) {
            if ($model->delete()) {
                $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!!')], $id);
            }
        } else {
            $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('app.c2', 'Pls termination schedule first!')], $id);
        }
        return $this->asJson($responseData);
    }

}
