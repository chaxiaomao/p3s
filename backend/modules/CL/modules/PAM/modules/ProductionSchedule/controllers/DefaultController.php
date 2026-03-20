<?php

namespace backend\modules\CL\modules\PAM\modules\ProductionSchedule\controllers;

use backend\models\c2\entity\cl\ProductionScheduleSearch;
use backend\models\c2\entity\ProductionScheduleTermination;
use common\models\c2\entity\OrderItem;
use common\models\c2\entity\Product;
use common\models\c2\entity\ProductCombination;
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

        $view = 'index';
        if ($searchModel->order_state == 'show_finished') {
            $view = 'index2';
        }

        return $this->render($view, [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetail()
    {
        $request = Yii::$app->request;
        if (!is_null($id = $request->post('id', $request->post('expandRowKey')))) {
            $models = ProductionScheduleItem::find()
                ->with('product.measure')
                ->where(['schedule_id' => $id])
                ->asArray()
                ->all();

            // $ps_product_ids = ArrayHelper::getColumn($models, 'product_id');
            $ids = ArrayHelper::getColumn($models, 'combination_id');

            $query = ProductionScheduleItem::find()
                ->alias('a')
                ->select([
                    'a.id',
                    'a.product_name',
                    'a.combination_name',
                    'a.combination_id',
                    'a.production_sum',
                    'a.enter_sum',
                    'ps.code',
                    'ps.label',
                ])
                ->leftJoin('{{%production_schedule}} ps', 'ps.id=a.schedule_id')
                ->where(['in', 'a.combination_id', $ids,])
                ->andWhere(['like', 'ps.label', 'cl'])
                ->orderBy([
                    'ps.position' => SORT_DESC,
                ]);

            $query->andWhere(['not', ['in', 'ps.state', [
                ProductionScheduleState::INIT,
                ProductionScheduleState::FINISH,
                ProductionScheduleState::TERMINATION,
            ]]]);

            $models2 = $query->asArray()->all();

            $production_sum = [];

            foreach ($models2 as $model) {
                $num = $model['production_sum'];
                if (isset($production_sum[$model['combination_id']])) {
                    $num = $production_sum[$model['combination_id']] + $num;
                }
                $production_sum[$model['combination_id']] = $num;
            }

            $ps_items = [];

            foreach ($models2 as $model) {
                $ps_items[$model['combination_id']][] = $model;
            }

            $product_stock = ProductCombination::getHashMap('id', 'stock', [
                'in', 'id', $ids,
            ]);

            return $this->renderPartial('checkv3', [
                'product_stock' => $product_stock,
                'models' => $models,
                'production_sum' => $production_sum,
                'ps_items' => $ps_items,
                'ps_id' => $id,
            ]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }

    }

    public function actionPsOrders($ids)
    {
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        $query = ProductionScheduleItem::find()
            ->alias('a')
            ->select([
                'a.product_id',
                'a.production_sum',
                'a.enter_sum',
                'ps.*',
            ])
            ->with('product.measure')
            ->leftJoin('{{%production_schedule}} ps', 'ps.id=a.schedule_id')
            ->where(['in', 'a.id', $ids])
            ->orderBy([
                'ps.position' => SORT_DESC,
            ]);

        $models = $query->asArray()->all();
        return $this->renderPartial('_ps_orders', [
            'orders' => $models
        ]);
    }

    public function actionPsMatters($psid, $psitemid, $ids)
    {
        $need_product_ids = ProductionConsumption::find()
            ->select('need_product_id')
            ->where(['schedule_item_id' => $psitemid])
            ->column();

        $query = ProductionConsumption::find()
            ->alias('a')
            ->select([
                'a.*',
                'ps.code',
                'ps.label',
                'ps.memo as ps_memo',
            ])
            ->with('product')
            ->with('product.measure')
            ->leftJoin('{{%production_schedule}} ps', 'ps.id=a.schedule_id')
            ->where(['in', 'a.need_product_id', $need_product_ids])
            ->andWhere(['like', 'ps.label', 'cl'])
            ->andWhere(['not', ['in', 'ps.state', [
                ProductionScheduleState::INIT,
                ProductionScheduleState::FINISH,
                ProductionScheduleState::TERMINATION,
            ]]])
            ->orderBy([
                'ps.position' => SORT_DESC,
                // 'ps.estimated_ship_date' => SORT_ASC,
            ]);

        $models = $query->asArray()->all();

        $need_sum = [];
        $send_sum = [];
        $products = [];
        $need_products = [];

        foreach ($models as $model) {
            $num = $model['need_sum'];
            $num2 = $model['send_sum'];
            if (isset($need_sum[$model['need_product_id']])) {
                $num = $need_sum[$model['need_product_id']] + $num;
            }
            if (isset($send_sum[$model['need_product_id']])) {
                $num2 = $send_sum[$model['need_product_id']] + $num2;
            }

            $need_sum[$model['need_product_id']] = $num;
            $send_sum[$model['need_product_id']] = $num2;

            if ($model['schedule_item_id'] == $psitemid) {
                $products[$model['need_product_id']] = $model;
            }

            $need_products[$model['need_product_id']][] = $model;

        }

        return $this->renderPartial('_matters', [
            'model' => $this->retrieveModel($psid),
            'need_sum' => $need_sum,
            'send_sum' => $send_sum,
            'products' => $products,
            'need_products' => $need_products,
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
