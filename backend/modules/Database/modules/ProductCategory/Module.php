<?php

namespace backend\modules\Database\modules\ProductCategory;

/**
 * product-category module definition class
 */
class Module extends \kartik\tree\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\Database\modules\ProductCategory\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
