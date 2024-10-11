<?php
defined('APP_ROOT') or define('APP_ROOT', dirname(__DIR__));
defined('CZA_BACKEND_THEME') or define('CZA_BACKEND_THEME', 'cza');

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$config = [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'language' => 'zh-CN',
    'bootstrap' => ['log'],
    'modules' => require(__DIR__ . '/modules.php'),
    // "aliases" => [
    //     "@mdm/admin" => "@vendor/mdmsoft/yii2-admin",
    // ],
    // 'as access' => [
    //     'class' => 'mdm\admin\components\AccessControl',
    //     'allowActions' => [
    //         '*'
    //     ], // 后面对权限完善了以后，记得把*改回来！
    // ],
    'components' => [
        // 'user' => [
        //     'identityClass' => 'backend\models\c2\entity\rbac\BeUser',
        //     'enableAutoLogin' => true,
        //     'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        // ],
        // 'as beforeAction' => [
        //     'class' => 'backend\components\actions\UserTimeLimitAction',
        // ],
        'user' => [
            'class' => 'backend\components\User',
            'identityClass' => 'backend\models\c2\entity\rbac\BeUser',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-backend',
                'path' => '/admin',
                'httpOnly' => true,
            ],
        ],
        'authManager' => [
            'class' => 'dektrium\rbac\components\DbManager',
            //            'class' => 'yii\rbac\PhpManager', // or use 'yii\rbac\DbManager'
        ],
        'formatter' => [
            'dateFormat' => 'Y-M-d',
        ],
        'view' => [
            'theme' => [
                'basePath' => '@app/themes/' . CZA_BACKEND_THEME,
                'baseUrl' => '@web/themes/' . CZA_BACKEND_THEME,
                'pathMap' => [
                    '@app/views' => ['@app/themes/' . CZA_BACKEND_THEME,],
                    '@app/modules' => '@app/themes/' . CZA_BACKEND_THEME . '/modules', // module's theme
                    '@app/widgets' => '@app/themes/' . CZA_BACKEND_THEME . '/widgets', // widget's theme
                ],
            ],
        ],
        'request' => [
            'class' => 'cza\base\components\web\Request',
            'noCsrfRoutes' => [
                'eshop/cashapply/default/cash-apply',
                'activity/record/record/send-money',
                'eshop/custom-service/allowance-form',
                'eshop/custom-service/audit-succ'
            ],
            'csrfParam' => '_csrf-backend',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'DB0uq8cLjtKgh6YYwm4cEZmXEQNrTZav',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'backendLog' => [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => "@runtime/logs/backend_info.log",
                    'categories' => ['application'],
                    'levels' => ['info',],
                    // belows setting will keep the log fresh
                    'maxFileSize' => 0,
                    'maxLogFiles' => 0,
                ],
                'db' => [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error'],
                    // 'logVars' => [],
                ],
                // 'backendSql' => [
                //     'class' => 'yii\log\FileTarget',
                //     'logFile' => "@runtime/logs/backend_sql.log",
                //     'categories' => ['yii\db\*'],
                //     'levels' => ['info'],
                //
                // ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => require(__DIR__ . '/seo.php'),
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
        'panels' => [
            'views' => ['class' => 'cza\base\components\panels\debug\ViewsPanel'],
        ],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1'],
        'generators' => [ //here
            'crud' => [ // generator name
                'class' => 'cza\gii\generators\crud\Generator', // generator class
                'templates' => [ //setting for out templates
                    '[BO] CCA2-Default' => '@cza/gii/generators/crud/bo-default', // template name => path to template
                    '[BO] CCA2 Popup' => '@cza/gii/generators/crud/bo-popup',
                    'Yii Default' => '@yii/gii/generators/crud/default', // template name => path to template
                ]
            ],
            'controller' => ['class' => 'yii\gii\generators\controller\Generator'],
            'form' => ['class' => 'yii\gii\generators\form\Generator'],
            'extension' => ['class' => 'yii\gii\generators\extension\Generator'],
            //            'model' => ['class' => 'yii\gii\generators\model\Generator'],
            'model' => ['class' => 'cza\gii\generators\model\Generator'],
        ],
    ];
}

return $config;