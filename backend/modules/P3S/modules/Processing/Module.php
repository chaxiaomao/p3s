<?php

namespace backend\modules\P3S\modules\Processing;

/**
 * processing module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\P3S\modules\Processing\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->modules = [
            'receipt-note' => [
                'class' => 'backend\modules\P3S\modules\Processing\modules\ReceiptNote\Module',
            ],
            'delivery-note' => [
                'class' => 'backend\modules\P3S\modules\Processing\modules\DeliveryNote\Module',
            ],
        ];
        // custom initialization code goes here
    }
}
