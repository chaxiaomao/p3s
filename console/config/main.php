<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
    ],
    'components' => [
        'log' => [
            //            'traceLevel' => YII_DEBUG ? 3 : 0,
            'flushInterval' => 1,  // flush immediately
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    //                    'levels' => ['error', 'warning'],
                    'levels' => ['error', 'warning'],
                    'logVars' => [],
                    //                    'exportInterval' => 1
                ],
                'consoleLog' => [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => "@runtime/logs/console_info.log",
                    'categories' => ['application'],
                    'levels' => ['info', 'trace'],
                    // belows setting will keep the log fresh
                    //                    'maxFileSize' => 0,
                    //                    'maxLogFiles' => 0,
                    'exportInterval' => 2, // <-- and here
                ],
                'chatLog' => [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => "@runtime/logs/chat_info.log",
                    'categories' => ['chat'],
                    'levels' => ['info'],
                    // belows setting will keep the log fresh
                    //                    'maxFileSize' => 0,
                    //                    'maxLogFiles' => 0,
                    'exportInterval' => 1, // <-- and here
                ],
                'eshopDebugLog' => [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => "@runtime/logs/eshop_debug.log",
                    'categories' => ['debug'],
                    'levels' => ['info'],
                    // belows setting will keep the log fresh
                    //                    'maxFileSize' => 0,
                    //                    'maxLogFiles' => 0,
                ],
                //                 'consoleSql' => [
                //                    'class' => 'yii\log\FileTarget',
                //                    'logFile' => "@runtime/logs/console_sql.log",
                //                    'categories' => ['yii\db\*'],
                //                    'levels' => ['info'],
                //                // belows setting will keep the log fresh
                ////                    'maxFileSize' => 0,
                ////                    'maxLogFiles' => 0,
                //                ],
            ],
        ],
    ],
    'params' => $params,
];
