<?php

namespace backend\modules\CL;

/**
 * cl module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\CL\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->modules = [
            'database' => [
                'class' => 'backend\modules\CL\modules\Database\Module',
            ],
            'pam' => [
                'class' => 'backend\modules\CL\modules\PAM\Module',
            ],
            'p3s' => [
                'class' => 'backend\modules\CL\modules\P3S\Module',
            ],
        ];
        // custom initialization code goes here
    }
}
