<?php


namespace backend\models\c2\form;


use common\models\c2\entity\ProductionConsumption;
use cza\base\models\ModelTrait;
use yii\base\Model;

class SabMixtureForm extends Model
{

    use ModelTrait;

    /**
     * @var ProductionConsumption
     */
    public $entityModel;
    public $number;

    public function rules()
    {
        return [
            [['number'], 'safe'],
        ];
    }

    public function send()
    {
        if (!is_null($this->entityModel)) {
            $this->entityModel->updateCounters(['send_sum' => $this->number]);
            // $this->entityModel->product->stock->updateCounters(['stock' => -($this->send_number)]);
            $product = $this->entityModel->product;
            if (!is_null($product)) {
                $product->stock -= $this->number;
                $product->save();
            }
            return true;
        }
        return false;
    }

    public function back()
    {
        if (!is_null($this->entityModel)) {
            $this->entityModel->updateCounters(['send_sum' => -($this->number)]);
            // $this->entityModel->product->stock->updateCounters(['stock' => -($this->send_number)]);
            $product = $this->entityModel->product;
            if (!is_null($product)) {
                $product->stock += $this->number;
                $product->save();
            }
            return true;
        }
        return false;
    }

}