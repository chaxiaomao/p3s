<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\c2\entity\BeUser */

$this->title = Yii::t('app.c2', 'Create Be User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app.c2', 'Be Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="be-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
