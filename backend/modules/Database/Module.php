<?php

namespace backend\modules\Database;

/**
 * database module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\Database\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->modules = [
            'product' => [
                'class' => 'backend\modules\Database\modules\Product\Module',
            ],
            'user' => [
                'class' => 'backend\modules\Database\modules\User\Module',
            ],
            'warehouse' => [
                'class' => 'backend\modules\Database\modules\Warehouse\Module',
            ],
            'supplier' => [
                'class' => 'backend\modules\Database\modules\Supplier\Module',
            ],
            'product-category' => [
                'class' => 'backend\modules\Database\modules\ProductCategory\Module',
            ],
            'material' => [
                'class' => 'backend\modules\Database\modules\Material\Module',
            ],
            'product-combination' => [
                'class' => 'backend\modules\Database\modules\ProductCombination\Module',
            ],
        ];
        // custom initialization code goes here
    }
}
