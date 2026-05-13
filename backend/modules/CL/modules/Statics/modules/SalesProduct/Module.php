<?php

namespace backend\modules\CL\modules\Statics\modules\SalesProduct;

/**
 * sales-product module definition class
 */
class Module extends \backend\components\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\CL\modules\Statics\modules\SalesProduct\controllers';

    public $permission = "P_CL_STATICS_SALES";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
