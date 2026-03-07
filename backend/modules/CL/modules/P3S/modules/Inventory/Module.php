<?php

namespace backend\modules\CL\modules\P3S\modules\Inventory;

/**
 * inventory module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\CL\modules\P3S\modules\Inventory\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->modules = [
            'receipt-note' => [
                'class' => 'backend\modules\CL\modules\P3S\modules\Inventory\modules\ReceiptNote\Module',
            ],
            'delivery-note' => [
                'class' => 'backend\modules\CL\modules\P3S\modules\Inventory\modules\DeliveryNote\Module',
            ],
        ];
        // custom initialization code goes here
    }
}
