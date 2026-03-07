<?php

namespace backend\modules\CL\modules\Database;

/**
 * database module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\CL\modules\Database\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->modules = [
            'product' => [
                'class' => 'backend\modules\CL\modules\Database\modules\Product\Module',
            ],
            'user' => [
                'class' => 'backend\modules\CL\modules\Database\modules\User\Module',
            ],
            'warehouse' => [
                'class' => 'backend\modules\CL\modules\Database\modules\Warehouse\Module',
            ],
            'supplier' => [
                'class' => 'backend\modules\CL\modules\Database\modules\Supplier\Module',
            ],
            'product-category' => [
                'class' => 'backend\modules\CL\modules\Database\modules\ProductCategory\Module',
            ],
            'material' => [
                'class' => 'backend\modules\CL\modules\Database\modules\Material\Module',
            ],
            'product-combination' => [
                'class' => 'backend\modules\CL\modules\Database\modules\ProductCombination\Module',
            ],
        ];
        // custom initialization code goes here
    }
}
