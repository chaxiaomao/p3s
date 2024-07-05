<?php


namespace backend\models\c2\entity;


use common\models\c2\entity\Product;
use common\models\c2\entity\ProductCombination;
use common\models\c2\entity\ProductionSchedule;
use common\models\c2\entity\ProductionScheduleItem;
use common\models\c2\statics\ProductionScheduleState;
use cza\base\models\ModelTrait;
use Yii;
use yii\base\Model;
use yii\validators\RequiredValidator;

class ProductionScheduleTermination extends Model
{
    use ModelTrait;

    public $produced_items;
    public $back_mixture_items;
    public $schedule_id;

    public function rules()
    {
        return [
            [['back_mixture_items', 'produced_items'], 'safe'],
            [['produced_items',], 'validateItems'],
        ];
    }

    public function validateItems($attribute)
    {
        $items = $this->$attribute;

        foreach ($items as $index => $row) {
            $requiredValidator = new RequiredValidator();
            $error = null;
            $requiredValidator->validate($row['product_id'], $error);
            $requiredValidator->validate($row['combination_id'], $error);
            $requiredValidator->validate($row['package_id'], $error);
            if (!empty($error)) {
                $key = $attribute . '[' . $index . '][product_id]';
                // $this->addError($key, Yii::t('app.c2', 'Product/Combination/Package not be null.'));
                $this->addError($key, Yii::t('app.c2', '{attribute} can not be empty!', ['attribute' => Yii::t('app.c2', 'Product')]));
            }
            if (!empty($error)) {
                $key = $attribute . '[' . $index . '][combination_id]';
                // $this->addError($key, Yii::t('app.c2', 'Product/Combination/Package not be null.'));
                $this->addError($key, Yii::t('app.c2', '{attribute} can not be empty!', ['attribute' => Yii::t('app.c2', 'Product Combination')]));
            }
        }
    }

    public function loadItems()
    {
        $this->items = ProductionScheduleItem::findAll(['schedule_id' => $this->schedule_id]);
    }

    public function save()
    {
        $schedule = ProductionSchedule::findOne($this->schedule_id);
        if ($schedule->state == ProductionScheduleState::TERMINATION) {
            $this->addError('state', Yii::t('app.c2', 'Schedule had terminated.'));
            return false;
        }
        // if (!empty($this->items)) {
        //     foreach ($this->items as $item) {
        //         $productCombination = ProductCombination::findOne($item['combination_id']);
        //         if (!is_null($productCombination)) {
        //             $productCombination->updateCounters(['stock' => $item['production_sum']]);
        //         }
        //         foreach ($productCombination->combinationItems as $combinationItem) {
        //             $combinationItem->product->updateCounters([
        //                 'stock' => -($item['production_sum'] * $combinationItem->need_number)
        //             ]);
        //         }
        //     }
        // }
        if (!empty($this->produced_items)) {
            foreach ($this->produced_items as $item) {
                $productCombination = ProductCombination::findOne($item['combination_id']);
                if (!is_null($productCombination)) {
                    // $productCombination->updateCounters(['stock' => $item['production_sum']]);
                    $productCombination->stock += isset($item['production_sum']) ? $item['production_sum'] : 0;
                    $productCombination->save();
                }
            }
            foreach ($this->back_mixture_items as $item) {
                $material = Product::findOne($item['product_id']);
                $material->stock += isset($item['back_mixture_sum']) ? $item['back_mixture_sum'] : 0;
                $material->save();
            }
        }
        $schedule->updateAttributes(['state' => ProductionScheduleState::TERMINATION]);
        return true;
    }

}