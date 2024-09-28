<?php

namespace backend\modules\PAM\modules\ProductionCommitNote\controllers;

use common\models\c2\entity\ProductionCommitNoteItem;
use common\models\c2\entity\ProductionSchedule;
use common\models\c2\statics\ProductionCommitNoteType;
use common\models\c2\statics\ProductionScheduleState;
use cza\base\models\statics\ResponseDatum;
use Yii;
use common\models\c2\entity\ProductionCommitNote;
use common\models\c2\search\ProductionCommitNoteSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for ProductionCommitNote model.
 */
class ProcessCommitNoteController extends Controller
{
    public $modelClass = 'backend\models\c2\entity\ProcessCommitNote';

    /**
     * Lists all ProductionCommitNote models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductionCommitNoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all ProductionCommitNote models.
     * @return mixed
     */
    public function actionRecord($id = null)
    {
        $searchModel = new ProductionCommitNoteSearch();
        $schedule = ProductionSchedule::findOne($id);
        $searchModel->schedule_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('record', [
            'model' => $this->retrieveModel(),
            'schedule' => $schedule,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductionCommitNote model.
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
     * create/update a ProductionCommitNote model.
     * fit to pajax call
     * @return mixed
     */
    public function actionEdit($id = null, $schedule_id = null)
    {
        $model = $this->retrieveModel($id);
        $model->schedule_id = $schedule_id;
        $model->type = ProductionCommitNoteType::PROCESS_COMMIT;
        
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
     * Finds the ProductionCommitNote model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductionCommitNote the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = \backend\models\c2\entity\MixtureCommitNote::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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

    public function actionDeleteSubitem($id)
    {
        if (($model = ProductionCommitNoteItem::findOne($id)) !== null) {
            if ($model->delete()) {
                $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!!')], $id);
            }
        }
        return $this->asJson($responseData);
    }

    public function actionAllFinish($id)
    {
        try {
            $model = \common\models\c2\entity\ProductionSchedule::findOne($id);
            if ($model->state != ProductionScheduleState::FINISH) {
                if ($model) {
                    $model->allProcessFinish();
                    $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
                } else {
                    $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!')], $id);
                }
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('app.c2', 'All Production Commit')], $id);
            }
        } catch (\Exception $ex) {
            $responseData = ResponseDatum::getErrorDatum(['message' => $ex->getMessage()], $id);
        }

        return $this->asJson($responseData);
    }

}
