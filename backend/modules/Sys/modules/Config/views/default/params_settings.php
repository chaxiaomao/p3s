<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use backend\modules\Sys\modules\Config\widgets\GeneralPanel;

$this->title = Yii::t('app.c2', 'Params Settings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app.c2', 'Configuration'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app.c2', 'Params Settings');
?>


<?= GeneralPanel::widget([
//    'withWechatTab' => true,
//    'withPerformanceTab' => false,
//    'withGeneralTab' => false,
//    'withApiTab' => false,
//    'withBusinessTab' => false,
//    'withUrlTab' => false,
//    'withGeoTab' => false,
    
    'withGeoTab' => true,
    'withWechatTab' => true,
    'withPerformanceTab' => true,
    'withGeneralTab' => true,
    'withApiTab' => true,
    'withBusinessTab' => true,
    'withUrlTab' => true,

]); ?>
