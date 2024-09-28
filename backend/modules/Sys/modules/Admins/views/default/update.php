<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\c2\entity\BeUser */

$this->title = Yii::t('app.c2', 'Update {modelClass}: ', [
    'modelClass' => 'Be User',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app.c2', 'Be Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app.c2', 'Update');
?>
<div class="be-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
