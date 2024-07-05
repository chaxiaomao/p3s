<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use softark\duallistbox\DualListbox;
use cza\base\widgets\ui\adminlte2\InfoBox;
use cza\base\models\statics\EntityModelStatus;
use yii\widgets\Pjax;
use yii\helpers\Url;
use cza\base\models\statics\OperationEvent;
use yii\web\JsExpression;

$messageName = $model->getMessageName();

?>

<?php
Pjax::begin(['id' => $model->getPjaxName(), 'formSelector' => $model->getBaseFormName(true), 'enablePushState' => false, 'clientOptions' => [
    'skipOuterContainers' => true,
    //    'fragment'=>'#blank',
    //    'container'=>'#blank'
    // 'dataType' => 'json'
]]);
?>

<?php
$form = ActiveForm::begin(['action' => 'cat-product-rs-save', 'options' => ['id' => $model->getBaseFormName(), 'data-pjax' => true]]);
?>

<div class="<?= $model->getPrefixName('form') ?>">
    <?php if (Yii::$app->session->hasFlash($messageName)): ?>
        <?php
        //        if (!$model->hasErrors()) {
        //            echo InfoBox::widget([
        //                'withWrapper' => false,
        //                'messages' => Yii::$app->session->getFlash($messageName),
        //            ]);
        //        } else {
        //            echo InfoBox::widget([
        //                'defaultMessageType' => InfoBox::TYPE_WARNING,
        //                'messages' => Yii::$app->session->getFlash($messageName),
        //            ]);
        //        }
        //        yii\web\View::registerJs("jQuery.msgGrowl ({
        //                    type:'1',
        //                    title: '" . Yii::t('cza', 'Tips') . "',
        //                    text:'123123',
        //                    position: 'top-center',
        //                    lifetime: 16500,
        //            });");
        ?>


    <?php endif; ?>

    <div class="well">
        <?php
        echo DualListbox::widget([
            'model' => $model,
            'attribute' => 'product_ids',
            'items' => \common\models\c2\entity\Product::getHashMap('id', 'name', ['NOT', ['id' => $model->entityModel->id]], ['status' => EntityModelStatus::STATUS_ACTIVE]),
            'options' => [
                'style' => "height:350px;",
                'multiple' => true,
            ],
            'clientOptions' => [
                'moveOnSelect' => false,
                'selectedListLabel' => Yii::t('app.c2', 'Associated Products'),
                'nonSelectedListLabel' => Yii::t('app.c2', 'Associable Products'),
            ],
        ]);
        echo Html::hiddenInput('entity_id', $model->entityModel->id);

        echo Html::beginTag('div', ['class' => 'box-footer']);
        echo Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('app.c2', 'Save'), ['id' => $model->getPrefixName('submit'), 'type' => 'button', 'class' => 'btn btn-primary pull-right']);
        echo Html::a('<i class="fa fa-arrow-left"></i> ' . Yii::t('app.c2', 'Go Back'), ['index'], ['class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Go Back'),]);
        echo Html::endTag('div');
        ?>
    </div>
</div>
<div id="blank" style="display:none;">
</div>
<?php ActiveForm::end() ?>
<?php Pjax::end(); ?>
<?php
$js = "";
//$js .= "jQuery('#hotSalePjax').off('pjax:send').on('pjax:send', function(){});\n";
//$js .= "jQuery('#hotSalePjax').off('pjax:complete').on('pjax:complete', function(){});\n";
$js .= "jQuery('" . $model->getPrefixName('submit', true) . "').on('click',function(e){
          // console.log(e);
        e.preventDefault();
        jQuery.fn.czaTools('showLoading', {selector:'" . $model->getPjaxName(true) . "', 'msg':''});
                jQuery.ajax({
                            url: '" . Url::toRoute('cat-product-rs-save') . "',
                            data:jQuery('" . $model->getBaseFormName(true) . "').serialize(), 
                            type:'post',
                            success: function(data) {
                                var lifetime = 6500;
                                if(data._meta.result == '" . cza\base\models\statics\OperationResult::SUCCESS . "'){
                                    jQuery('#{$model->getPrefixName('grid')}').trigger('" . OperationEvent::REFRESH . "');
                                }
                                else{
                                  lifetime = 16500;
                                }
                                jQuery.msgGrowl ({
                                        type: data._meta.type, 
                                        title: '" . Yii::t('cza', 'Tips') . "',
                                        text: data._meta.message,
                                        position: 'top-center',
                                        lifetime: lifetime,
                                });
                            },
                            error :function(data){alert(data._meta.message);},
                            complete:function(){jQuery.fn.czaTools('hideLoading', {selector:'" . $model->getPjaxName(true) . "'});}
                    });
              



     });";
//$js .= "jQuery('#hotSalePjax').on('pjax:beforeReplace', function(content){ $(this).trigger('pjax:end')});\n";
//$js .= "jQuery('#hotSalePjax').off('pjax:success').on('pjax:success', function(data,status,xhr,option){
//    
//        });\n";
//$js .= "jQuery('#hotSalePjax').on('ready pjax:end', function(event) {
//       jQuery(event.target).initializeMyPlugin()
//})\n";
$this->registerJs($js);
?>
