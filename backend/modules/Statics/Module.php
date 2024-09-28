<?php

namespace backend\modules\Statics;

/**
 * statics module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\Statics\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->modules = [
            'sales-product' => [
                'class' => 'backend\modules\Statics\modules\SalesProduct\Module',
            ],
            'warehouse-commit-note' => [
                'class' => 'backend\modules\Statics\modules\WarehouseCommitNote\Module',
            ],
            'receipt-items' => [
                'class' => 'backend\modules\Statics\modules\ReceiptItems\Module',
            ],
            'delivery-items' => [
                'class' => 'backend\modules\Statics\modules\DeliveryItems\Module',
            ],
        ];
        // custom initialization code goes here
    }
}
