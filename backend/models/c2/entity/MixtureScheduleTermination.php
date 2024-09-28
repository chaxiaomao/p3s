<?php


namespace backend\models\c2\entity;


use common\models\c2\entity\Product;
use common\models\c2\entity\ProductCombination;
use common\models\c2\entity\ProductionSchedule;
use common\models\c2\statics\ProductionScheduleState;
use cza\base\models\ModelTrait;
use Yii;
use yii\base\Model;

class MixtureScheduleTermination extends Model
{
    use ModelTrait;

    public $items;
    public $schedule_id;

    public function rules()
    {
        return [
            [['items'], 'safe'],
        ];
    }

    public function save()
    {
        $schedule = ProductionSchedule::findOne($this->schedule_id);
        if ($schedule->state == ProductionScheduleState::TERMINATION) {
            $this->addError('state', Yii::t('app.c2', 'Schedule had terminated.'));
            return false;
        }
        if (!empty($this->items)) {
            foreach ($this->items as $item) {
                $material = Product::findOne($item['product_id']);
                if (!is_null($material)) {
                    // $productCombination->updateCounters(['stock' => $item['production_sum']]);
                    $material->stock += isset($item['production_sum']) ? $item['production_sum'] : 0;
                    $material->save();
                }
            }
        }
        $schedule->updateAttributes(['state' => ProductionScheduleState::TERMINATION]);
        return true;
    }

}