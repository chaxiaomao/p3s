<?php

namespace backend\modules\CL\modules\P3S;

/**
 * p3s module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\CL\modules\P3S\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->modules = [
            'order' => [
                'class' => 'backend\modules\CL\modules\P3S\modules\Order\Module',
            ],
            'product-stock' => [
                'class' => 'backend\modules\P3S\modules\ProductStock\Module',
            ],
            'inventory' => [
                'class' => 'backend\modules\CL\modules\P3S\modules\Inventory\Module',
            ],
            'processing' => [
                'class' => 'backend\modules\P3S\modules\Processing\Module',
            ],
            'warehouse' => [
                'class' => 'backend\modules\P3S\modules\Warehouse\Module',
            ],
            'warehouse-note' => [
                'class' => 'backend\modules\P3S\modules\WarehouseNote\Module',
            ],
            'warehouse-note-item' => [
                'class' => 'backend\modules\P3S\modules\WarehouseNoteItem\Module',
            ],
        ];
        // custom initialization code goes here
    }
}
