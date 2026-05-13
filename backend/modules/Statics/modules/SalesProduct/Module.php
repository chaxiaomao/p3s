<?php

namespace backend\modules\Statics\modules\SalesProduct;

use Yii;

/**
 * sales-product module definition class
 */
class Module extends \backend\components\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\Statics\modules\SalesProduct\controllers';

    public $permission = "P_STATICS_SALES";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
