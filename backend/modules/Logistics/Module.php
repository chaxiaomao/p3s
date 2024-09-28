<?php

namespace backend\modules\Logistics;

use backend\components\Module as BaseModule;

/**
 * logistics module definition class
 */
class Module extends BaseModule
{

    public $permission = "P_Logistics";

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\Logistics\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->modules = [
            'region' => [
                'class' => 'backend\modules\Logistics\modules\Region\Module',
            ],
            'measure' => [
                'class' => 'backend\modules\Logistics\modules\Measure\Module',
            ],
            'currency' => [
                'class' => 'backend\modules\Logistics\modules\Currency\Module',
            ],
        ];
        // custom initialization code goes here
    }

}
