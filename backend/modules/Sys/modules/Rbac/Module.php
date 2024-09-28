<?php

namespace backend\modules\Sys\modules\Rbac;

use backend\components\Module as BaseModule;

/**
 * rbac module definition class
 */
class Module extends BaseModule {
//class Module extends \yii\base\Module {

    public $permission = "";

    /**
     * @inheritdoc
     */
//    public $controllerNamespace = 'backend\modules\Sys\modules\Rbac\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        // custom initialization code goes here
    }

}
