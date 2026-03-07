<?php

namespace backend\modules\CL\modules\PAM;

/**
 * pam module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\CL\modules\PAM\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->modules = [
            'order-item' => [
                'class' => 'backend\modules\CL\modules\PAM\modules\OrderItem\Module',
            ],
            'production-schedule' => [
                'class' => 'backend\modules\CL\modules\PAM\modules\ProductionSchedule\Module',
            ],
            'production-consumption' => [
                'class' => 'backend\modules\CL\modules\PAM\modules\ProductionConsumption\Module',
            ],
            'mixture-schedule' => [
                'class' => 'backend\modules\CL\modules\PAM\modules\MixtureSchedule\Module',
            ],
            'production-commit-note' => [
                'class' => 'backend\modules\CL\modules\PAM\modules\ProductionCommitNote\Module',
            ],
            'process-schedule' => [
                'class' => 'backend\modules\CL\modules\PAM\modules\ProcessSchedule\Module',
            ],


        ];

        // custom initialization code goes here
    }
}
