<?php

namespace backend\modules\P3S\modules\Inventory\modules\DeliveryNote;

use backend\components\Module as BaseModule;
use Yii;

/**
 * delivery-note module definition class
 */
class Module extends BaseModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\P3S\modules\Inventory\modules\DeliveryNote\controllers';

    public $permission = "P_DELIVERY";


    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
