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
//                'baseUrl' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('baseUrl')]],
//                'imageBaseUrl' =>  ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('imageBaseUrl')]],
                'cdnEnable' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => \cza\base\models\statics\EntityModelState::getHashMap('id', 'label')],
                'cdnImageBaseUrl' =>  ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('cdnImageBaseUrl')]],
                'cdnVideoBaseUrl' =>  ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('cdnVideoBaseUrl')]],
                'eshopUrl' =>  ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('eshopUrl')]],
            ]
        ]);

        //百度金桥
        echo "<div class='panel panel-default'>";
        echo "<div class='panel-heading'>".Yii::t('app.c2', 'Baidu Bridge Customer Service')."</div>";
        echo "<div class='panel-body'>";
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'baiduBridgeJs' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => $model->getAttributeLabel('baiduBridgeJs')]],
                'baiduBridgeLink' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('baiduBridgeLink')]],
            ]
        ]);
        echo "</div></div>";
        //end

        //百度统计
        echo "<div class='panel panel-default'>";
        echo "<div class='panel-heading'>".Yii::t('app.c2', 'Baidu Statistics')."</div>";
        echo "<div class='panel-body'>";
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'baiduStatisticsJs' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => $model->getAttributeLabel('baiduStatisticsJs')]],
            ]
        ]);
        echo "</div></div>";
        //end

        echo Html::hiddenInput('modelClass', $model::className());
        
        echo "<span class='glyphicon glyphicon-exclamation-sign text-danger'></span> <a href='#general-panel-tabs-tab1' data-toggle='tab'><small class='text-danger to-performance' >"
        .Yii::t('app.c2', 'The revised performance options to clear the corresponding cache, then the onset').
        "</small></a>";
        echo Html::beginTag('div', ['class' => 'box-footer']);
        echo Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('app.c2', 'Save'), ['type' => 'button', 'class' => 'btn btn-primary pull-right']);
        echo Html::endTag('div');
        ?>
    </div>

</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>

<?php
$js="$('.to-performance').on('click', function(){ $('#general-panel-tabs li:eq(1)').tab('show')    });";
$this->registerJs($js);
?>