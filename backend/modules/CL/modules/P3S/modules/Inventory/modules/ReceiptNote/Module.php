<?php

namespace backend\modules\CL\modules\P3S\modules\Inventory\modules\ReceiptNote;

/**
 * receipt-note module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\CL\modules\P3S\modules\Inventory\modules\ReceiptNote\controllers';

    public $permission = "P_CL_PURCHASE";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
