<?php

define('BACKEND_BASE_URL', 'http://be-jade.tunnel.echomod.cn');
define('FRONTEND_BASE_URL', 'http://fe-apollo-pre.local.bulletelc.com');
define('ESHOP_BASE_URL', 'http://eshop-apollo-pre.local.bulletelc.com');
// define('IMAGE_BASE_URL', 'http://img.local.pache.com');
define('IMAGE_BASE_URL', 'http://pache-img.jiebao91.com');

//define('BACKEND_BASE_URL', 'https://be-apollo-pre-staging.bulletelc.com');
//define('FRONTEND_BASE_URL', 'https://fe-apollo-pre-staging.bulletelc.com');
//define('ESHOP_BASE_URL', 'https://eshop-apollo-pre-staging.bulletelc.com');
//define('IMAGE_BASE_URL', 'https://img-apollo-pre-staging.bulletelc.com');

//define('BACKEND_BASE_URL', 'https://be-apollo-pre.kebiyj.com');
//define('FRONTEND_BASE_URL', 'https://fe-apollo-pre.kebiyj.com');
//define('ESHOP_BASE_URL', 'https://eshop-apollo-pre.kebiyj.com');
//define('IMAGE_BASE_URL', 'https://img-apollo-pre.kebiyj.com');

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@appimage', dirname(dirname(__DIR__)) . '/app_image/uploads');
Yii::setAlias('@app_eshop', dirname(dirname(__DIR__)) . '/app_eshop');
