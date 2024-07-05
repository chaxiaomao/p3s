<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use backend\modules\Sys\modules\Config\widgets\TransferPanel;

$this->title = Yii::t('app.c2', 'Transfer Settings');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app.c2', 'Configuration'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app.c2', 'Transfer Settings');
?>

<?= TransferPanel::widget([
    'withDistributorTab' => true,
    'withFranchiseeTab' => true,
    'withShopTab' => true,
]); ?>