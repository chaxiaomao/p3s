<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model  */
/* @var $form yii\widgets\ActiveForm */

$js = "jQuery('body').on('beforeSubmit','form#performance-form', function () {
     var form = $(this);
     // return false if form still have some validation errors
     if (form.find('.has-error').length) {
          return false;
     }
     // submit form
     jQuery.ajax({
          url: form.attr('action'),
          type: 'post',
          data: form.serialize(),
          success: function (response) {
//             console.log(response);
               // do something with response
          }
     });
     return false;
});";

$this->registerJs($js);
?>

<?php $form = ActiveForm::begin(['id' => 'performance-form', 'action' => Url::to('sys-config/default/save')]); ?>
<?= Html::hiddenInput('modelClass', $model->className()) ?>
<?= $form->field($model, 'cacheEnable')->textInput(['maxlength' => 200]) ?>
<?= $form->field($model, 'cacheDuration')->textInput(['maxlength' => 200]) ?>



<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>