<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace backend\components;

use Yii;
use yii\base\Module as BaseModule;
use yii\filters\AccessControl;

/**
 * @author Ben Bi (bennybi@qq.com)
 */
class Module extends BaseModule {

    /**
     * @var string The permission name.
     */
    public $permission;

    /** @inheritdoc */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => [$this, 'checkAccess'],
                    ]
                ],
            ],
        ];
    }

    /**
     * Checks access.
     *
     * @return bool
     */
    public function checkAccess() {
        if (!empty($this->permission)) {
            return Yii::$app->user->can($this->permission);
        } elseif (!is_null($this->module) && $this->module instanceof Module) {
            return $this->module->checkAccess();
        }
        return true;
    }

}
