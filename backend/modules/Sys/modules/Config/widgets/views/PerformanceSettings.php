<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use cza\base\models\statics\OperationEvent;
use cza\base\widgets\ui\adminlte2\InfoBox;
use common\models\c2\statics\SwitchState;
use common\models\c2\statics\ConfigType;
use yii\bootstrap\Modal;

$messageName = $model->getMessageName();
$url = yii\helpers\Url::toRoute('refresh');
$success = Yii::t('cza', 'Tips');
$this->registerCss(".input-group.bootstrap-touchspin {width: 50%;}");
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
         echo Html::beginTag('div', ['class' => 'box-footer']);
            echo Html::button(Yii::t('app.c2', 'CRM Refresh'), ['type' => 'button', 'class' => 'btn btn-primary pull-left flush', 'data-sign' => 'CRM', 'data-toggle' => 'modal', 'data-target' => '#confirm-modal', 'data-id' => 'confirm-modal']);
            echo Html::button(Yii::t('app.c2', 'EShop Refresh'), ['type' => 'button', 'class' => 'btn btn-primary pull-left flush', 'data-sign' => 'Eshop', 'data-toggle' => 'modal', 'data-target' => '#confirm-modal', 'data-id' => 'confirm-modal']);
            echo Html::button(Yii::t('app.c2', 'Backend Refresh'), ['type' => 'button', 'class' => 'btn btn-primary pull-left flush', 'data-sign' => 'Backend', 'data-toggle' => 'modal', 'data-target' => '#confirm-modal', 'data-id' => 'confirm-modal']);
            echo Html::button(Yii::t('app.c2', 'Console Refresh'), ['type' => 'button', 'class' => 'btn btn-primary pull-left flush', 'data-sign' => 'Console', 'data-toggle' => 'modal', 'data-target' => '#confirm-modal', 'data-id' => 'confirm-modal']);
            echo Html::button(Yii::t('app.c2', 'All Refresh'), ['type' => 'button', 'class' => 'btn btn-primary pull-left flush', 'data-sign' => 'All', 'data-toggle' => 'modal', 'data-target' => '#confirm-modal', 'data-id' => 'confirm-modal']);
        echo Html::endTag('div');
        ?>
    </div>
    <div class="well">
        <?php
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'cacheEnable' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => SwitchState::getHashMap('id', 'label')],
                'cacheDuration' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\touchspin\TouchSpin', 'options' => [
                        'pluginOptions' => [
                            'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>',
                            'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                            'max' => 8640000,
                        ],
                    ],],
                'productPriceCacheDuration' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\touchspin\TouchSpin', 'options' => [
                        'pluginOptions' => [
                            'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>',
                            'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                            'max' => 8640000,
                        ],
                    ],],
            ]
        ]);
        echo Html::hiddenInput('modelClass', $model::className());
        echo Html::beginTag('div', ['class' => 'box-footer']);
        echo Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('app.c2', 'Save'), ['type' => 'button', 'class' => 'btn btn-primary pull-right']);
        echo Html::endTag('div');
        ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>

<?php
//$js = <<<JS
//$(document).on('click', '.flush', function(){
//    var content = $(this).attr('data-sign');
//    $.post("$url", 
//        {'sign':content},
//        function (data) {
//            console.log(data);
//            $.msgGrowl({
//                type: data._meta.type, 
//                title: "$success",
//                text: data._meta.message,
//                position: 'top-right',
//            });
//        }
//   );
//});
//JS;
//$this->registerJs($js);
Modal::begin([
    'id' => 'confirm-modal',
    'header' => '<h4 class="modal-title">' . Yii::t('app.c2', 'Confirmation prompt') . '</h4>',
    'footer' => '<a href="#" class="btn btn-primary data-confirm-submit" data-dismiss="modal">' . Yii::t('app.c2', 'Confirm operation') . '</a> <a href="#" class="btn btn-primary" data-dismiss="modal">' . Yii::t('app.c2', 'Close operation') . '</a>', ]);

$confirmJs = "
    var content = null;
    $('.flush').on('click', function () {
        $('.modal-body').html('".Yii::t('app.c2', 'Warning : Please Confirm Operation!')."');
        content = $(this).attr('data-sign');
    });
    $('.data-confirm-submit').on('click', function () { 
          console.log(content);
        $.post(\"$url\", 
            {'sign':content},
            function (data) {
                console.log(data);
                $.msgGrowl({
                    type: data._meta.type, 
                    title: \"$success\",
                    text: data._meta.message,
                    position: 'top-right',
                });
            }
        ); 
    });
    ";
$this->registerJs($confirmJs);
Modal::end();
?>