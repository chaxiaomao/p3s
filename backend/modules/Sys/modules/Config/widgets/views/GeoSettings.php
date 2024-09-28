<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use cza\base\models\statics\OperationEvent;
use cza\base\widgets\ui\adminlte2\InfoBox;
use cza\base\models\statics\EntityModelStatus;
use common\models\c2\statics\ConfigType;
use common\widgets\TencentLocpicker;

$messageName = $model->getMessageName();
?>
<?php Pjax::begin(['id' => $model->getPjaxName(), 'enablePushState' => false]) ?>
<?php
$form = ActiveForm::begin([
            'action' => ['params-geo-save',],
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
        echo TencentLocpicker::widget([
            'id' => 'map-container',
            'key' => Yii::$app->settings->get('api\tencent_dev_app_key'),
            'coord' => $model->getCoordinate(),
            'mapOptions' => [
                'width' => '100%',
                'height' => '600px',
            ]
        ]);
        ?>
        <?php
        echo Html::activeHiddenInput($model, 'companyLatitude', ['id' => 'companyLatitude']);
        echo Html::activeHiddenInput($model,'companyLongitude', ['id' => 'companyLongitude']);
        echo Html::hiddenInput('modelClass', $model::className());
        echo Html::beginTag('div', ['class' => 'box-footer']);
        echo Html::button('<i class="fa fa-save"></i> ' . Yii::t('app.c2', 'Save'), ['id' => 'geo-btn-save', 'type' => 'button', 'class' => 'btn btn-primary pull-right']);
        echo Html::endTag('div');
        ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
<?php
$js = "";
$js .= "$(document).off('" . OperationEvent::COORDINATE_CHANGE . "').on('" . OperationEvent::COORDINATE_CHANGE . "', '#map-container', function(e, data){
//            console.log(data.latlng);
            if(data.latlng != null){
              $('#companyLatitude').attr('value', data.latlng.lat);
              $('#companyLongitude').attr('value', data.latlng.lng);
            }
        });";
$js .= "\n";

$js .= "jQuery('#geo-btn-save').on('click', function(e) {
                   var vForm = jQuery('#" . $model->getBaseFormName() . "');
                   jQuery.ajax({
                            url: vForm.attr('action'),
                            type: 'post',
                            data: vForm.serialize(),
                            success: function(data) {
                                jQuery.msgGrowl ({
                                        type: data._meta.type, 
                                        title: '" . Yii::t('cza', 'Tips') . "',
                                        text: data._meta.message,
                                        position: 'top-right',
                                });
                            },
                            error :function(data){alert(data._meta.message);}
                    });
                    return false;
                });";
$js .= "\n";

$this->registerJs($js);
?>
