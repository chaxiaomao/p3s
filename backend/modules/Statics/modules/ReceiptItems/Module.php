<?php

namespace backend\modules\Statics\modules\ReceiptItems;

/**
 * receipt-items module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\Statics\modules\ReceiptItems\controllers';

    public $permission = "P_STATICS_PURCHASE";
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
