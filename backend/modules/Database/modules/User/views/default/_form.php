<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use cza\base\widgets\ui\adminlte2\InfoBox;
use cza\base\models\statics\EntityModelStatus;

$regularLangName = \Yii::$app->czaHelper->getRegularLangName();
$messageName = $model->getMessageName();
?>

<?php
$form = ActiveForm::begin([
    'action' => ['edit', 'id' => $model->id],
    'options' => [
        'id' => $model->getBaseFormName(),
        'data-pjax' => true,
    ]]);
?>

<div class="<?= $model->getPrefixName('form') ?>
">
    <?php if (Yii::$app->session->hasFlash($messageName)): ?>
        <?php if (!$model->hasErrors()) {
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
                'type' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => \common\models\c2\statics\FeUserType::getHashMap('id', 'label')],
                // 'attributeset_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('attributeset_id')]],
                'username' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('username')]],
                'email' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('email')]],
                // 'password_hash' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('password_hash')]],
                // 'auth_key' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('auth_key')]],
                // 'confirmed_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\widgets\DateTimePicker', 'options' => [
                //     'options' => ['placeholder' => Yii::t('app.c2', 'Date Time...')], 'pluginOptions' => ['format' => 'yyyy-mm-dd hh:ii:ss', 'autoclose' => true],
                // ],],
                // 'unconfirmed_email' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('unconfirmed_email')]],
                // 'blocked_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\widgets\DateTimePicker', 'options' => [
                //     'options' => ['placeholder' => Yii::t('app.c2', 'Date Time...')], 'pluginOptions' => ['format' => 'yyyy-mm-dd hh:ii:ss', 'autoclose' => true],
                // ],],
                // 'registration_ip' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('registration_ip')]],
                // 'registration_src_type' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\checkbox\CheckboxX', 'options' => [
                //     'pluginOptions' => ['threeState' => false],
                // ],],
                // 'flags' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('flags')]],
                // 'last_login_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\widgets\DateTimePicker', 'options' => [
                //     'options' => ['placeholder' => Yii::t('app.c2', 'Date Time...')], 'pluginOptions' => ['format' => 'yyyy-mm-dd hh:ii:ss', 'autoclose' => true],
                // ],],
                // 'last_login_ip' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('last_login_ip')]],
                // 'open_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('open_id')]],
                // 'wechat_union_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('wechat_union_id')]],
                // 'wechat_open_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('wechat_open_id')]],
                'mobile_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('mobile_number')]],
                // 'access_token' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('access_token')]],
                // 'district_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('district_id')]],
                // 'province_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('province_id')]],
                // 'city_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('city_id')]],
                'status' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => EntityModelStatus::getHashMap('id', 'label')],
                'position' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\touchspin\TouchSpin', 'options' => [
                    'pluginOptions' => [
                        'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>',
                        'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                    ],
                ],],
            ]
        ]);
        echo Html::beginTag('div', ['class' => 'box-footer']);
        echo Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('app.c2', 'Save'), ['type' => 'button', 'class' => 'btn btn-primary pull-right']);
        echo Html::a('<i class="fa fa-arrow-left"></i> ' . Yii::t('app.c2', 'Go Back'), ['index'], ['data-pjax' => '0', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Go Back'),]);
        echo Html::endTag('div');
        ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
