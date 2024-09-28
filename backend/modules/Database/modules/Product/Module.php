<?php

namespace backend\modules\Database\modules\Product;

/**
 * product module definition class
 */
class Module extends \kartik\tree\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\Database\modules\Product\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->modules = [
            'combination' => [
                'class' => 'backend\modules\Database\modules\Product\modules\Combination\Module',
            ],
            'package' => [
                'class' => 'backend\modules\Database\modules\Product\modules\Package\Module',
            ],
        ];
        // custom initialization code goes here
    }
}
