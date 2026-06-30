<?php

namespace backend\modules\CL\modules\PAM\modules\ProductionConsumption\controllers;

use backend\models\c2\form\SabMixtureForm;
use common\models\c2\entity\Measure;
use common\models\c2\entity\ProductionSchedule;
use common\models\c2\entity\ProductionScheduleItem;
use common\models\c2\entity\WarehouseNoteItem;
use common\models\c2\statics\ProductionScheduleState;
use common\models\c2\statics\WarehouseNoteItemStatus;
use cza\base\models\statics\ResponseDatum;
use Yii;
use common\models\c2\entity\ProductionConsumption;
use common\models\c2\search\ProductionConsumptionSearch;

use cza\base\components\controllers\backend\ModelController as Controller;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for ProductionConsumption model.
 */
class DefaultController extends Controller
{
    public $modelClass = 'common\models\c2\entity\ProductionConsumption';

    /**
     * Lists all ProductionConsumption models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductionConsumptionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'scheduleId' => Yii::$app->request->queryParams['ProductionConsumptionSearch']['schedule_id'],
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all ProductionConsumption models.
     * @return mixed
     */
    public function actionSendRecord()
    {
        $id =  Yii::$app->request->queryParams['ProductionConsumptionSearch']['schedule_id'];
        $data1 = ProductionConsumption::find()->where(['schedule_id' => $id])->all();
        $data2 = WarehouseNoteItem::find()->where(['ref_note_id' => $id])->all();
        $ids = ArrayHelper::getColumn($data1, function($ele) {
            return $ele->need_product_id;
        });
        $data = $data1;

        foreach ($data2 as $item2) {
            if (!in_array($item2['product_id'], $ids)) {
                $data[] = [
                    'id' => $item2->product_id,
                    'need_product_sku' => $item2->product_name,
                    'need_product_name' => $item2->product_sku,
                    'need_product_label' => $item2->product_label,
                    'need_product_value' => $item2->product_value,
                    'need_sum' => '',
                    'send_sum' => $item2->status == WarehouseNoteItemStatus::COMMIT ? $item2['number'] : 0,
                    'memo' => $item2->memo,
                    // 'status' => $item2['memo'],
                    // 'measure' => $item2['product_value'],
                ];
            }
        }
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => false, // Disable pagination if not needed
        ]);
        return $this->render('index_send_record', [
            // 'data' => $data,
            'dataProvider' => $dataProvider,
        ]);
        // $searchModel = new ProductionConsumptionSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // return $this->render('index_send_record', [
        //     'model' => $this->retrieveModel(),
        //     // 'scheduleId' => Yii::$app->request->queryParams['ProductionConsumptionSearch']['schedule_id'],
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);
    }


    /**
     * Lists all ProductionConsumption models.
     * @return mixed
     */
    public function actionCheckV2()
    {
        $searchModel = new ProductionConsumptionSearch();
        $searchModel->schedule_id = Yii::$app->request->get('schedule_id');
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('checkV2', [
            'model' => $this->retrieveModel(),
            'scheduleId' => Yii::$app->request->get('schedule_id'),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        // $searchModel = new ProductionConsumptionSearch();
        // $searchModel->schedule_id = Yii::$app->request->queryParams['schedule_id'];
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // return $this->render('checkV2', [
        //     'model' => $this->retrieveModel(),
        //     'scheduleId' => Yii::$app->request->queryParams['ProductionConsumptionSearch']['schedule_id'],
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);
    }

    public function actionCheck($id)
    {
        $query = ProductionConsumption::find()->where(['schedule_id' => $id]);
        $query->select(['*', new Expression('SUM(need_sum) as sum')]);
        $query->with('product.measure');
        $query->groupBy(['need_product_id']);
        return $this->render('check', ['data' => $query->asArray()->all()]);
    }

    /**
     * Displays a single ProductionConsumption model.
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
     * create/update a ProductionConsumption model.
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

        return (Yii::$app->request->isAjax) ? $this->renderAjax('edit', ['model' => $model,]) : $this->render('edit', ['model' => $model,]);
    }

    /**
     * Finds the ProductionConsumption model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ProductionConsumption the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductionConsumption::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSendMixture($id = null, $product_id = null)
    {
        $this->layout = '/main-block';
        $model = new SabMixtureForm(['entityModel' => $this->retrieveModel($id)]);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->send()) {
                Yii::$app->session->setFlash($model->getMessageName(), [Yii::t('app.c2', 'Saved successful.')]);
            } else {
                Yii::$app->session->setFlash($model->getMessageName(), $model->errors);
            }
        }

        return (Yii::$app->request->isAjax) ? $this->renderAjax('send_mixture_form', ['model' => $model,]) : $this->render('send_mixture_form', ['model' => $model,]);
    }

    public function actionBackMixture($id = null, $product_id = null)
    {
        $this->layout = '/main-block';
        $model = new SabMixtureForm(['entityModel' => $this->retrieveModel($id)]);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->back()) {
                Yii::$app->session->setFlash($model->getMessageName(), [Yii::t('app.c2', 'Saved successful.')]);
            } else {
                Yii::$app->session->setFlash($model->getMessageName(), $model->errors);
            }
        }

        return (Yii::$app->request->isAjax) ? $this->renderAjax('back_mixture_form', ['model' => $model,]) : $this->render('send_mixture_form', ['model' => $model,]);
    }

    public function actionAllSend($id)
    {
        try {
            $model = \common\models\c2\entity\ProductionSchedule::findOne($id);
            if ($model->state != ProductionScheduleState::ALL_SEND) {
                if ($model) {
                    $model->allMixtureSend();
                    $responseData = ResponseDatum::getSuccessDatum(['message' => Yii::t('cza', 'Operation completed successfully!')], $id);
                } else {
                    $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('cza', 'Error: operation can not finish!')], $id);
                }
            } else {
                $responseData = ResponseDatum::getErrorDatum(['message' => Yii::t('app.c2', 'All Send Commit')], $id);
            }
        } catch (\Exception $ex) {
            $responseData = ResponseDatum::getErrorDatum(['message' => $ex->getMessage()], $id);
        }

        return $this->asJson($responseData);
    }
}
