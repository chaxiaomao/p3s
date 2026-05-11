<?php

namespace backend\modules\CL\modules\PAM\modules\ProcessSchedule;

/**
 * process-schedule module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\CL\modules\PAM\modules\ProcessSchedule\controllers';

    public $permission = "P_CL_PROCESS_SCHEDULE";
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
