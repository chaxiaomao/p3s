<?php

namespace backend\modules\CL\modules\Statics\modules\DeliveryItems;

/**
 * delivery-items module definition class
 */
class Module extends \backend\components\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\CL\modules\Statics\modules\DeliveryItems\controllers';

    public $permission = "P_CL_STATICS_DELIVERY";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
