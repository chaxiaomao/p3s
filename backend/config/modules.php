<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/3/22
 * Time: 15:47
 */

return [
    'database' => [
        'class' => 'backend\modules\Database\Module',
    ],
    'p3s' => [
        'class' => 'backend\modules\P3S\Module',
    ],
    'pam' => [
        'class' => 'backend\modules\PAM\Module',
    ],
    'statics' => [
        'class' => 'backend\modules\Statics\Module',
    ],

    // common modules
    'logistics' => ['class' => 'backend\modules\Logistics\Module',],
    'sys' => ['class' => 'backend\modules\Sys\Module',],
    'rbac' => [
        'class' => 'backend\modules\Sys\modules\Rbac\Module',
        'permission' => 'P_System',
    ],
    'user' => [
        'class' => 'backend\modules\Sys\modules\Admins\Module',
        'enableConfirmation' => false,
        'enableRegistration' => false,
        'adminPermission' => 'P_System',
        'modelMap' => [
            'RegistrationForm' => 'backend\models\c2\entity\rbac\RegistrationForm',
            'Profile' => 'backend\models\c2\entity\rbac\BeUserProfile',
            'SettingsForm' => 'backend\models\c2\entity\rbac\SettingsForm',
            'User' => 'backend\models\c2\entity\rbac\BeUser',
            'LoginForm' => 'backend\models\c2\form\LoginForm',
        ],
    ],
    /*  CZA & Kartik Public Service Modules, Begin ** */
    'attachments' => [
        'class' => 'cza\base\modules\Attachments\Module',
    ],
    'treemanager' => [
        'class' => '\kartik\tree\Module',
    ],
    'gridview' => [
        'class' => 'kartik\grid\Module',
        'downloadAction' => '/attachments/export/download',
    ],
    // 'log-reader' => [
    //     'class' => 'zhuravljov\yii\logreader\Module',
    //     'aliases' => [
    //         'backend Errors' => '@backend/runtime/logs/backend_debug.log',
    //         'backend Info' => '@backend/runtime/logs/backend_info.log',
    //         'Console Errors' => '@backend/runtime/logs/app.log',
    //
    //     ],
    // ],
    /*  CZA & Kartik Public Service Modules, End ** */
];