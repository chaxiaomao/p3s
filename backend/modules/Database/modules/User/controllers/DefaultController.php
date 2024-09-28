<?php

namespace backend\modules\Database\modules\User\controllers;

use common\models\c2\entity\FeUserProfile;
use common\models\c2\statics\ProductionScheduleState;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\ResponseDatum;
use Yii;
use common\models\c2\entity\FeUser;
use common\models\c2\search\FeUserSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for FeUserModel model.
 */
class DefaultController extends Controller
{
    public $modelClass = 'common\models\c2\entity\FeUser';
    
    /**
     * Lists all FeUserModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FeUserSearch();
        $searchModel->status = EntityModelStatus::STATUS_ACTIVE;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FeUserModel model.
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
     * create/update a FeUserModel model.
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
     * Finds the FeUserModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return FeUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FeUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionEditProfile($id = null)
    {
        $model = FeUserProfile::findOne($id);
        if (is_null($model)) {
            $model = new FeUserProfile();
        }

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash($model->getMessageName(), [Yii::t('app.c2', 'Saved successful.')]);
            } else {
                Yii::$app->session->setFlash($model->getMessageName(), $model->errors);
            }
        }

        return (Yii::$app->request->isAjax) ? $this->renderAjax('_profile_form', [ 'model' => $model,]) : $this->render('_profile_form', [ 'model' => $model,]);
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model) {
            if ($model->updateAttributes(['status' => EntityModelStatus::STATUS_INACTIVE])) {
                $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!!')], $id);
            }
        } else {
            $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('app.c2', 'Error: operation can not finish!!')], $id);
        }
        return $this->asJson($responseData);
    }

}
