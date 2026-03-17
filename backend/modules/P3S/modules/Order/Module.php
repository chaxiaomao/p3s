<?php

namespace backend\modules\P3S\modules\Order;

use Yii;

/**
 * order module definition class
 */
class Module extends \backend\components\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\P3S\modules\Order\controllers';

    public $permission = "P_ORDER";


    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->modules = [
            'order-item-consumption' => [
                'class' => 'backend\modules\P3S\modules\Order\modules\OrderItemConsumption\Module',
            ],
            'order-item' => [
                'class' => 'backend\modules\P3S\modules\Order\modules\OrderItem\\Module',
            ],
        ];
        // custom initialization code goes here
    }
}
