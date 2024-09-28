<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */
namespace backend\modules\Sys\modules\Rbac\controllers;

use dektrium\rbac\controllers\RoleController as BaseController;

/**
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class RoleController extends BaseController
{
    protected $modelClass = 'backend\models\c2\entity\rbac\Role';
}