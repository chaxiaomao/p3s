<?php

namespace backend\modules\Database\modules\Supplier;

/**
 * supplier module definition class
 */
class Module extends \backend\components\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\Database\modules\Supplier\controllers';

    public $permission = "P_SUPPILER";
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
