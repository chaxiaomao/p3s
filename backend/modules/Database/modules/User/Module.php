<?php

namespace backend\modules\Database\modules\User;

/**
 * user module definition class
 */
class Module extends \backend\components\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\Database\modules\User\controllers';

    public $permission = "P_USER";
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
