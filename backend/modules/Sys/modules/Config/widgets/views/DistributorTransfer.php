<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30
 * Time: 10:20
 */

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use cza\base\widgets\ui\adminlte2\InfoBox;
use common\models\c2\statics\TransferType;

$messageName = $model->getMessageName();
?>
<?php Pjax::begin(['id' => $model->getPjaxName(), 'enablePushState' => false]) ?>
<?php
$form = ActiveForm::begin([
    'action' => ['transfer-save',],
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
                'originalDistributorId' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'options' => [
                        'language' => Yii::$app->language,
                        'class' => 'form-control client fs-12 col-lg-5',
                        'data' => common\models\c2\entity\Distributor::getDistributeHashMapByPhone('user_id', 'name' ,'mobile_number'),
                        'options'=>[
                            'placeholder'=>Yii::t('app.c2','Please choose the original Distributor'),
                        ],
                    ],
                ],
                'targetDistributorId' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\widgets\Select2',
                    'options'=>[
                        'language' => Yii::$app->language,
                        'class' => 'form-control client fs-12 col-lg-5',
                        'data' => common\models\c2\entity\Distributor::getDistributeHashMapByPhone('user_id', 'name' ,'mobile_number'),
                        'options'=>[
                            'placeholder'=>Yii::t('app.c2','Please select the target Distributor'),
                        ],
                    ],
                ],
            ]
        ]);
        echo Html::hiddenInput('modelClass', $model::className());
        echo Html::hiddenInput('transferType',  TransferType::DISTRIBUTOR_TRANSFER);
        echo Html::beginTag('div', ['class' => 'box-footer']);
        echo Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('app.c2', 'Save'), ['type' => 'button', 'class' => 'btn btn-primary pull-right']);
        echo Html::endTag('div');
        ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>

