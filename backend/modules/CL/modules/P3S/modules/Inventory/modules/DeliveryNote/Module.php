<?php

namespace backend\modules\CL\modules\P3S\modules\Inventory\modules\DeliveryNote;

use Yii;

/**
 * delivery-note module definition class
 */
class Module extends \backend\components\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\CL\modules\P3S\modules\Inventory\modules\DeliveryNote\controllers';

    public $permission = "P_CL_DELIVERY";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
