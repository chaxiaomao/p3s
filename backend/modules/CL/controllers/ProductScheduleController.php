<?php

namespace backend\modules\CL\controllers;

use backend\models\c2\entity\cl\ProductionScheduleItemSearch;
use common\helpers\CodeGenerator;
use common\models\c2\entity\ProductionConsumption;
use common\models\c2\entity\ProductionSchedule;
use common\models\c2\entity\ProductionScheduleItem;
use common\models\c2\statics\ProductionScheduleState;
use Yii;
use yii\db\Expression;
use yii\web\NotFoundHttpException;

use cza\base\components\controllers\backend\ModelController as Controller;

/**
 * Default controller for the `news` module
 */
class ProductScheduleController extends Controller
{

    public $modelClass = 'common\models\c2\entity\ProductionScheduleItem';

    public function actionCostSheet()
    {
        $searchModel = new ProductionScheduleItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'model' => $this->retrieveModel(),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDetail()
    {
        $request = Yii::$app->request;
        if (!is_null($id = $request->post('id', $request->post('expandRowKey')))) {
            $model = ProductionScheduleItem::findOne($id);
            $product_id = $model->product_id;
            $scheduleIds =ProductionScheduleItem::find()
                ->alias('a')
                ->select([
                    'a.schedule_id',
                    'a.product_id',
                ])
                ->leftJoin('{{%production_schedule}} ps', 'ps.id=a.schedule_id')
                ->where([
                    'a.product_id' => $product_id,
                ])
                ->andWhere(['like', 'ps.label', 'cl'])
                ->andWhere(['in', 'ps.state', [ProductionScheduleState::COMMIT, ProductionScheduleState::CALCULATION]])
                ->column();
            // print_r($scheduleIds->createCommand()->getRawSql());

            $models = ProductionConsumption::find()
                ->alias('pc')
                ->select([
                    'pc.*',
                    'ps.code',
                    'ps.label',
                    'ps.memo',
                    'ps.state',
                    'ps.occurrence_date',
                    'ps.estimated_ship_date',
                    'ps.actual_ship_date',
                ])
                ->leftJoin('{{%production_schedule}} ps', 'ps.id=pc.schedule_id')
                ->with('product.measure')
                ->where(['in', 'schedule_id', $scheduleIds])
                ->asArray()->all();

            return $this->renderPartial('_detail', ['models' => $models]);
        } else {
            return '<div class="alert alert-danger">No data found</div>';
        }
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionCostSheet1()
    {
        $datetime = Yii::$app->request->get('datetime', '');
        if (empty($datetime)) {
            $start = date('Y-m');
            $datetime = $start;
        }
        $start = $datetime . '-01 00:00:00';
        $end = date('Y-m-d H:i:s', strtotime($start . ' +1 month'));
        $models = ProductionConsumption::find()
            // ->select(['*', new Expression('SUM(need_sum) as sum')])
            ->alias('pc')
            ->select([
                'pc.*',
                'ps.code',
                'ps.label',
            ])
            ->leftJoin('{{%production_schedule}} ps', 'ps.id=pc.schedule_id')
            ->with('product.measure')
            // ->with('product')
            ->where(['like', 'ps.label', 'cl'])
            ->andWhere(['>=', 'ps.occurrence_date', $start])
            ->andWhere(['<', 'ps.occurrence_date', $end])
            ->andWhere(['in', 'ps.state', [ProductionScheduleState::COMMIT, ProductionScheduleState::CALCULATION]])
            // ->groupBy(['need_product_id'])
            ->asArray()->all();
        return $this->render('index', [
            'models' => $models,
            'datetime' => $datetime,
        ]);
    }


}
