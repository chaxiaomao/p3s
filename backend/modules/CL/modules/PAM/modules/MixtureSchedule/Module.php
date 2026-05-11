<?php

namespace backend\modules\CL\modules\PAM\modules\MixtureSchedule;

/**
 * mixture-schedule module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\CL\modules\PAM\modules\MixtureSchedule\controllers';

    public $permission = "P_CL_MIXTURE_SCHEDULE";
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
