<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace backend\modules\Sys\modules\Rbac\widgets;

use yii\bootstrap\Nav;

/**
 * Menu widget.
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class Menu extends Nav
{
    /**
     * @inheritdoc
     */
    public $options = [
        'class' => 'nav-tabs'
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $userModuleClass       = 'dektrium\user\Module';
        $isUserModuleInstalled = \Yii::$app->getModule('user') instanceof $userModuleClass;

        $this->items = [
            [
                'label'   => \Yii::t('app.c2', 'Users'),
                'url'     => ['/user/admin/index'],
                'visible' => $isUserModuleInstalled,
            ],
            [
                'label' => \Yii::t('app.c2', 'Roles'),
                'url'   => ['/rbac/role/index'],
            ],
            [
                'label' => \Yii::t('app.c2', 'Permissions'),
                'url'   => ['/rbac/permission/index'],
            ],
            [
                'label' => \Yii::t('app.c2', 'Rules'),
                'url'   => ['/rbac/rule/index'],
            ],
            [
                'label' => \Yii::t('app.c2', 'Create'),
                'items' => [
                    [
                        'label'   =>\ Yii::t('app.c2', 'User'),
                        'url'     => ['/user/admin/create'],
                        'visible' => $isUserModuleInstalled,
                    ],
                    [
                        'label' => \Yii::t('app.c2', 'Role'),
                        'url'   => ['/rbac/role/create']
                    ],
                    [
                        'label' => \Yii::t('app.c2', 'Permission'),
                        'url'   => ['/rbac/permission/create']
                    ],
                    [
                        'label' => \Yii::t('app.c2', 'Rule'),
                        'url'   => ['/rbac/rule/create']
                    ]
                ]
            ],
        ];
    }
}