<?php

namespace backend\modules\CL\controllers;

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

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionCostSheet()
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
            ->where(['>=', 'occurrence_date', $start])
            ->andWhere(['<', 'occurrence_date', $end])
            ->andWhere(['in', 'ps.state', [ProductionScheduleState::COMMIT, ProductionScheduleState::CALCULATION]])
            // ->groupBy(['need_product_id'])
            ->asArray()->all();
        return $this->render('index', [
            'models' => $models,
            'datetime' => $datetime,
        ]);
    }


}
