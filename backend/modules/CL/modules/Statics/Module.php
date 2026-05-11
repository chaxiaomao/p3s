<?php

namespace backend\modules\CL\modules\Statics;

/**
 * statics module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\CL\modules\Statics\controllers';

    public $permission = "P_CL_PROCESS_SCHEDULE";
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->modules = [
            'sales-product' => [
                'class' => 'backend\modules\CL\modules\Statics\modules\SalesProduct\Module',
            ],
            'warehouse-commit-note' => [
                'class' => 'backend\modules\CL\modules\Statics\modules\WarehouseCommitNote\Module',
            ],
            'receipt-items' => [
                'class' => 'backend\modules\CL\modules\Statics\modules\ReceiptItems\Module',
            ],
            'delivery-items' => [
                'class' => 'backend\modules\CL\modules\Statics\modules\DeliveryItems\Module',
            ],
        ];
        // custom initialization code goes here
    }
}
