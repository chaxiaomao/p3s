<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\c2\search\OrderItemConsumptionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-item-consumption-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'order_id') ?>

    <?= $form->field($model, 'order_item_id') ?>

    <?= $form->field($model, 'need_product_id') ?>

    <?= $form->field($model, 'need_product_sku') ?>

    <?php // echo $form->field($model, 'need_product_name') ?>

    <?php // echo $form->field($model, 'need_product_label') ?>

    <?php // echo $form->field($model, 'need_product_value') ?>

    <?php // echo $form->field($model, 'sale_product_sum') ?>

    <?php // echo $form->field($model, 'need_number') ?>

    <?php // echo $form->field($model, 'need_sum') ?>

    <?php // echo $form->field($model, 'memo') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'position') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app.c2', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app.c2', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
