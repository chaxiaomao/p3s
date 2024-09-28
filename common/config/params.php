<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'config' => [
        'languages' => ['en', 'zh-CN'],
        'beBaseUrl' => BACKEND_BASE_URL,
        'feBaseUrl' => FRONTEND_BASE_URL,
        'eshopBaseUrl' => ESHOP_BASE_URL,
        'feUser' => [
            'authorizeUrl' => FRONTEND_BASE_URL . '/authorize',
            'uploadPath' => '@runtime/uploads/temp/user',
        ],
        'shop' => [
            'uploadPath' => '@runtime/uploads/temp/shop',
        ],
        'admin' => [
            'email' => 'admin@zdt6.com',
            'algorithm' => 'sha1',
        ],
        'upload' => [// config system upload files folder, including products/topics/articles... related files
            //            'accessUrl' => '/uploads/store',
            //            'storePath' => '@frontend/web/uploads/store',
            'accessUrl' => IMAGE_BASE_URL . '/store',
            'storePath' => '@appimage/store',
            'tempPath' => '@runtime/uploads/temp',
            'imageWhiteExts' => ['gif', 'png', 'jpg', 'jpeg'],
            'fileWhiteExts' => ['mp4', 'swf', 'zip', 'pdf', 'doc', 'docx', 'xlsx', 'txt'],
            'maxFileSize' => 5097152, // 5MB
            'maxFiles' => 10, // Allow to upload maximum files, default to 5
        ],
        'pagination' => [
            'pageSize' => 20,
        ],
        //        'userdata' => [// config customer/member users' related file folder, including user's album/order... files
        //            'path' => 'userdata', // save under webroot
        //            'maxFileSize' => "200mb",
        //        ],
        //        'currency' => [// default currency, if not set local currency
        //            'code' => 'CNY',
        //        ],
        //        'geo' => [
        //            'enable' => true,
        ////            'defaultLatLng' => ["22.3964280000", "114.1094970000"], // default latitude and longitude is HongKong China
        //            'defaultLatLng' => ["23.1291630000", "113.2644350000"], // default latitude and longitude is GuangZhou China
        //        ],
        //        // Common JqueryUi Widget preferences:
        //        'juiPrefs' => [
        //            'themePath' => '/css/jui',
        //            'theme' => 'ui-lightness', // 'smoothness'
        //        ],

        'api' => [
            'secret' => '5955418f95abae997be50efeb5c0cd98',
        ]
    ],
];
