<?php
defined('CZA_FRONTEND_THEME') or define('CZA_FRONTEND_THEME', 'sunflower');
$params = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/params.php')
);
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'language' => 'zh-CN',
    'bootstrap' => ['log','log-reader'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => require(__DIR__ . '/modules.php'),
    'components' => [
        'formatter' => [
            'dateFormat' => 'Y-M-d',
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'enableCsrfValidation' => false,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'backendLog' => [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => "@runtime/logs/backend_info.log",
                    'categories' => ['application'],
                    'levels' => ['info', 'trace'],
                    // belows setting will keep the log fresh
                    'maxFileSize' => 0,
                    'maxLogFiles' => 0,
                ],
                'backendSql' => [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => "@runtime/logs/backend_sql.log",
                    'categories' => ['yii\db\*'],
                    'levels' => ['info'],

                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'view' => [
            'theme' => [
                'basePath' => '@app/themes/' . CZA_FRONTEND_THEME,
                'baseUrl' => '@web/themes/' . CZA_FRONTEND_THEME,
                'pathMap' => [
                    '@app/views' => ['@app/themes/' . CZA_FRONTEND_THEME,],
                    '@app/modules' => '@app/themes/' . CZA_FRONTEND_THEME . '/modules', // module's theme
                    '@app/widgets' => '@app/themes/' . CZA_FRONTEND_THEME . '/widgets', // widget's theme
                ],
            ],
        ],
    ],
    'params' => $params,
];
