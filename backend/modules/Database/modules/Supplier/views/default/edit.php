<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use backend\modules\Database\modules\Supplier\widgets\EntityDetail;

/* @var $this yii\web\View */
/* @var $model common\models\c2\entity\Supplier */

if($model->isNewRecord){
$this->title = Yii::t('app.c2', '{actionTips} {modelClass}: ', ['actionTips' => Yii::t('app.c2', 'Create'), 'modelClass' => Yii::t('app.c2', 'Supplier'),]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app.c2', 'Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
}
else{
$this->title = Yii::t('app.c2', '{actionTips} {modelClass}: ', ['actionTips' => Yii::t('app.c2', 'Update'), 'modelClass' => Yii::t('app.c2', 'Supplier'),]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app.c2', 'Suppliers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app.c2', 'Update');
}
?>

<?php Pjax::begin(['id' => $model->getDetailPjaxName(), 'formSelector' => $model->getBaseFormName(true), 'enablePushState' => false, 'clientOptions' =>[
    'skipOuterContainers'=>true
]]) ?>

<?php echo EntityDetail::widget([
    'model' => $model,
    'tabTitle' =>  $this->title,
]);
?>

<?php $js = "";
$js.= "jQuery('{$model->getDetailPjaxName(true)}').off('pjax:send').on('pjax:send', function(){jQuery.fn.czaTools('showLoading', {selector:'{$model->getDetailPjaxName(true)}', 'msg':''});});\n";
$js.= "jQuery('{$model->getDetailPjaxName(true)}').off('pjax:complete').on('pjax:complete', function(){jQuery.fn.czaTools('hideLoading', {selector:'{$model->getDetailPjaxName(true)}'});});\n";
$this->registerJs($js);
?>
<?php  Pjax::end() ?>

