<?php

use cza\base\models\statics\EntityModelStatus;
use cza\base\widgets\ui\adminlte2\InfoBox;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

$regularLangName = \Yii::$app->czaHelper->getRegularLangName();
$messageName = $model->getMessageName();
?>
<?php
Pjax::begin(['id' => $model->getDetailPjaxName(), 'formSelector' => $model->getBaseFormName(true), 'enablePushState' => false, 'clientOptions' => [
    'skipOuterContainers' => true
]]);

?>

<?php
$form = ActiveForm::begin([
    'action' => ['send-mixture', 'id' => $model->entityModel->id],
    'options' => [
        'id' => $model->getBaseFormName(),
        'data-pjax' => true,
        'style' => 'padding:20px',
    ]]);
?>

    <div class="<?= $model->getPrefixName('form') ?>">
        <?php if (Yii::$app->session->hasFlash($messageName)): ?>
            <?php if (!$model->hasErrors()) {
                echo InfoBox::widget([
                    'withWrapper' => false,
                    'messages' => Yii::$app->session->getFlash($messageName),
                ]);
                $this->registerJs("$('#send_number').val(0)");
                $this->registerJs(
                    "jQuery('#consumption-refresh').click();"
                );
            } else {
                echo InfoBox::widget([
                    'defaultMessageType' => InfoBox::TYPE_WARNING,
                    'messages' => Yii::$app->session->getFlash($messageName),
                ]);
            }
            ?>
        <?php endif; ?>

        <p style="color: red;">提示：请输入送料数量，保存成功后即时扣减物料库存，请勿重复提交！</p>
        <?php

        $product = $model->entityModel->product;
        ?>
        <p><?= !is_null($product) ? $product->name . '（库存：' . $product->stock . '）' : '' ?></p>

        <div class="well">
            <?php
            echo Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 2,
                'attributes' => [
                    'number' => [
                        'label' => Yii::t('app.c2', 'Send Number'),
                        'type' => Form::INPUT_TEXT,
                        'options' => [
                            'id' => 'send_number',
                            'placeholder' => Yii::t('app.c2', 'Send Number')
                        ]
                    ],
                ]
            ]);
            echo Html::beginTag('div', ['class' => 'box-footer']);
            echo Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('app.c2', 'Save'), ['type' => 'button', 'class' => 'btn btn-primary pull-right']);
            echo Html::a('<i class="fa fa-window-close-o"></i> ' . Yii::t('app.c2', 'Close'), ['index'], ['data-pjax' => '0', 'data-dismiss' => 'modal', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Close'),]);
            echo Html::endTag('div');
            ?>
        </div>
    </div>
<?php ActiveForm::end(); ?>

<?php Pjax::end(); ?>