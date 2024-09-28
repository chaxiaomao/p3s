<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
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
            'columns' => 2,
            'attributes' => [
                
                'wechatSubscribeQrcode' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\FileInput',
                    'options' => [
                        'options' => [
                            'accept' => 'image/*',
                        ],
                        'pluginOptions' => [
                            'uploadUrl' => Url::to(['file-upload']),
                            'allowedFileExtensions' => ['jpg', 'gif', 'png'],
                            'browseClass' => 'btn btn-primary btn-block',
                            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                            'browseLabel' => \Yii::t('app.c2', 'Upload Qrcode'),
                            'previewFileType' => 'image',
                            'showCaption' => false,
                            'showRemove' => false,
                            'showUpload' => false,
                            'maxFileCount' => 1,
//                            'resizeImage' => true,
//                            'maxImageWidth' => 150,
//                            'maxImageHeight' => 150,
                            'initialPreview' => $model->getInitialPreview('wechatSubscribeQrcode'),
                            'initialPreviewConfig' => $model->getInitialPreview('wechatSubscribeQrcode'),
                        ],
                    ],
                ],
                'applyDistrbutorQrcodeImage' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => 'common\widgets\QrCode',
                    'options' => [
                        'qrCodeAttribute' => 'applyDistrbutorQrcode',
                        'qrCodeImageAttribute' => 'applyDistrbutorQrcodeImage',
                        'linkId' => 'qr-code-link1',
                        'pjaxId' => 'qr-code-pjax1',
                        'readonly' => false,
                        'options' => [],
                        'pluginOptions' => [],
                    ],
                ],
                'applyMerchantQrcodeImage' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => 'common\widgets\QrCode',
                    'options' => [
                        'qrCodeAttribute' => 'applyMerchantQrcode',
                        'qrCodeImageAttribute' => 'applyMerchantQrcodeImage',
                        'linkId' => 'qr-code-link2',
                        'pjaxId' => 'qr-code-pjax2',
                        'readonly' => false,
                        'options' => [],
                        'pluginOptions' => [],
                    ],
                ],
                'nearestShopQrcodeImage' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => 'common\widgets\QrCode',
                    'options' => [
                        'qrCodeAttribute' => 'nearestShopQrcode',
                        'qrCodeImageAttribute' => 'nearestShopQrcodeImage',
                        'linkId' => 'qr-code-link3',
                        'pjaxId' => 'qr-code-pjax3',
                        'readonly' => false,
                        'options' => [],
                        'pluginOptions' => [],
                    ],
                ],
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

