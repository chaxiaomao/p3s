<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use cza\base\models\statics\OperationEvent;
use cza\base\widgets\ui\adminlte2\InfoBox;
use cza\base\models\statics\EntityModelStatus;
use common\models\c2\statics\ConfigType;

$messageName = $model->getMessageName();
?>
<?php Pjax::begin(['id' => $model->getPjaxName(), 'enablePushState' => false]) ?>
<?php
$form = ActiveForm::begin([
            'action' => ['params-save',],
            'options' => [
                'id' => $model->getBaseFormName(),
                'data-pjax' => true,
        ]]);
?>

<div class="<?= $model->getPrefixName('form') ?>">
    <?php if (Yii::$app->session->hasFlash($messageName)): ?>
        <?php
        if (!$model->hasErrors()) {
            echo InfoBox::widget([
                'withWrapper' => false,
                'messages' => Yii::$app->session->getFlash($messageName),
            ]);
        } else {
            echo InfoBox::widget([
                'defaultMessageType' => InfoBox::TYPE_WARNING,
                'messages' => Yii::$app->session->getFlash($messageName),
            ]);
        }
        ?>
    <?php endif; ?>

    <div class="well">
        <?php
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'tencentDevAppKey' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('tencentDevAppKey')]],
            ]
        ]);

//        echo "<div class='panel panel-default'>";
//        echo "<div class='panel-heading'>".Yii::t('app.c2', 'Baidu Bridge Customer Service')."</div>";
//        echo "<div class='panel-body'>";
//        echo Form::widget([
//            'model' => $model,
//            'form' => $form,
//            'columns' => 1,
//            'attributes' => [
//                'baiduBridgeJs' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => $model->getAttributeLabel('baiduBridgeJs')]],
//                'baiduBridgeLink' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('baiduBridgeLink')]],
//            ]
//        ]);
//        echo "</div></div>";

        echo Html::hiddenInput('modelClass', $model::className());
        echo Html::beginTag('div', ['class' => 'box-footer']);
        echo Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('app.c2', 'Save'), ['type' => 'button', 'class' => 'btn btn-primary pull-right']);
        echo Html::endTag('div');
        ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>