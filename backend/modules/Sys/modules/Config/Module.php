<?php

namespace backend\modules\Sys\modules\Config;

use backend\components\Module as BaseModule;

class Module extends BaseModule {

    public $permission = "";
    public $controllerNamespace = 'backend\modules\Sys\modules\Config\controllers';

    public function init() {
        parent::init();
        // custom initialization code goes here
    }

}
