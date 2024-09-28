<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

$linkId = $this->context->linkId;
$pjaxId = $this->context->pjaxId;
$readonly = $this->context->readonly;
$model = $this->context->model;
$qrCodeAttribute = $this->context->qrCodeAttribute;
$qrCodeImageModel = $model->getOneAttachment($qrCodeAttribute);
$qrCodeImageStr = is_null($qrCodeImageModel) ? "" : Html::img($qrCodeImageModel->getOriginalUrl(), []);

?>
<?php Pjax::begin(['id' => $pjaxId, 'linkSelector' => "#{$linkId}", 'enablePushState' => false]); ?>

<div class="file-input file-input-ajax-new">
    <div class="file-preview ">
        <div class=" file-drop-zone">
            <?php if (!empty($qrCodeImageStr)): ?>
                <div class="file-preview-thumbnails">
                    <?php echo $qrCodeImageStr ?>
                </div>
            <?php else: ?>
                <div class="file-drop-zone-title"><?= $this->context->defaultLabel ?><br></div>
            <?php endif ?>

            <div class="clearfix"></div>   
            <div class="file-preview-status text-center text-success"></div>
            <div class="kv-fileinput-error file-error-message" style="display: none;"></div>
        </div>
    </div>
    <div style="margin-bottom:5px;">
        <div class="input-group"><span class="input-group-addon"><i class="fa fa-address-card-o"></i></span>
                <?php
                echo Html::activeTextInput($model, $qrCodeAttribute, [
                    'class' => 'form-control',
                    'placeholder' => Yii::t('app.c2', 'Enter QrCode content'),
                    'readonly' => $readonly,
                    'value' => is_null($qrCodeImageModel) ? "" : $qrCodeImageModel->content,
                ])
                ?>
        </div>

    </div>

    <?php echo Html::a('<i class="glyphicon glyphicon-camera"></i> <span class="hidden-xs">' . Yii::t('app.c2', 'Reenerate QR Code') . '</span>', null, ['id' => $linkId, 'class' => 'btn btn-primary btn-block btn-file']) ?>

</div>
<?php Pjax::end(); ?>
<?php
$js = "";
if ($readonly) {
    $js.= "jQuery(document).off('click', '#{$linkId}').on('click', '#{$linkId}', function(e, data){
                e.preventDefault();
                jQuery.pjax({
                    type: 'POST',
                    url: '{$this->context->action}',
                    container: '#{$pjaxId}',
                    data: {id:'{$model->id}', codeAttribute:'{$qrCodeAttribute}', content:''},
                    push:false
                  });
            });";
} else {
    $js.= "jQuery(document).off('click', '#{$linkId}').on('click', '#{$linkId}', function(e, data){
                e.preventDefault();
                jQuery.pjax({
                    type: 'POST',
                    url: '{$this->context->action}',
                    container: '#{$pjaxId}',
                    data: {id:'{$model->id}', codeAttribute:'{$qrCodeAttribute}', content:jQuery('#" . Html::getInputId($model, $qrCodeAttribute) . "').val() },
                    push:false
                  });
            });";
}

$this->registerJs($js);
?>


