<?php

namespace backend\modules\Sys;

use Yii;
use backend\components\Module as BaseModule;

class Module extends BaseModule {

    public $permission = "P_System";
    public $controllerNamespace = 'backend\modules\Sys\controllers';

    public function checkAccess() {
        if (strpos(Yii::$app->requestedRoute, 'common-resource')) {
            return true;
        }
        if (!empty($this->permission)) {
            return Yii::$app->user->can($this->permission);
        } elseif (!is_null($this->module) && $this->module instanceof Module) {
            return $this->module->checkAccess();
        }
        return true;
    }

    public function init() {
        parent::init();
        $this->modules = [
            'admins' => ['class' => 'backend\modules\Sys\modules\Admins\Module'],
            'config' => ['class' => 'backend\modules\Sys\modules\Config\Module'],
            'rbac' => ['class' => 'backend\modules\Sys\modules\Rbac\Module'],
            'common-resource' => ['class' => 'backend\modules\Sys\modules\CommonResource\Module'],
        ];
        // custom initialization code goes here
    }

}
