<?php

use cza\base\models\statics\OperationEvent;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use cza\base\widgets\ui\adminlte2\InfoBox;
use cza\base\models\statics\EntityModelStatus;
use yii\helpers\Url;

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
            $this->registerJs(
                "jQuery('#package-refresh').click();"
            );
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
            'columns' => 4,
            'attributes' => [
                'product_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('product_id'), 'readonly' => true]],
                'name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('name')]],
                'label' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('label')]],
                'product_capacity' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('product_capacity')]],
                'gross_weight' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('gross_weight')]],
                'net_weight' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('net_weight')]],
                'status' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => EntityModelStatus::getHashMap('id', 'label')],
                'position' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\touchspin\TouchSpin', 'options' => [
                    'pluginOptions' => [
                        'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>',
                        'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                    ],
                ],],
            ]
        ]);

        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 2,
            'attributes' => [
                'memo' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\vova07\imperavi\Widget', 'options' => [
                    'settings' => [
                        'minHeight' => 150,
                        'buttonSource' => true,
                        'lang' => $regularLangName,
                        'plugins' => [
                            'fontsize',
                            'fontfamily',
                            'fontcolor',
                            'table',
                            'textdirection',
                            'fullscreen',
                        ],
                    ]
                ],],
            ]
        ]);

        $multipleItemsId = $model->getPrefixName('items');
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'items' => [
                    'type' => Form::INPUT_WIDGET,
                    'label' => Yii::t('app.c2', 'Add Product Package Items'),
                    'widgetClass' => unclead\multipleinput\MultipleInput::className(),
                    'options' => [
                        'id' => $multipleItemsId,
                        'data' => $model->items,
                        //  'max' => 4,
                        'allowEmptyList' => true,
                        'rowOptions' => function ($model, $index, $context) use ($multipleItemsId) {
                            return ['id' => "row{multiple_index_{$multipleItemsId}}", 'data-id' => $model['id']];
                        },
                        'columns' => [
                            [
                                'name' => 'id',
                                'type' => 'hiddenInput',
                            ],
                            [
                                'name' => 'label',
                                'title' => Yii::t('app.c2', 'Label'),
                                'options' => [
                                ],
                            ],
                            [
                                'name' => 'product_id',
                                // 'type' => 'dropDownList',
                                'title' => Yii::t('app.c2', 'Material'),
                                'enableError' => true,
                                // 'items' => ['' => Yii::t("app.c2", "Select options ..")] + \common\models\c2\entity\ProductModel::getHashMap('id', 'sku', ['status' => EntityModelStatus::STATUS_ACTIVE]),
                                'type' => \kartik\select2\Select2::className(),
                                'options' => [
                                    'data' => \backend\models\c2\entity\Material::getMixedOptions('id', 'sku', [
                                        'type' => \common\models\c2\statics\ProductType::TYPE_MATERIAL,
                                        'status' => EntityModelStatus::STATUS_ACTIVE
                                    ]),
                                ],
                            ],
                            [
                                'name' => 'need_number',
                                'title' => Yii::t('app.c2', 'Need Number'),
                                'enableError' => true,
                                'defaultValue' => '1',
                                'options' => [
                                    'type' => 'number',
                                    'min' => '1',
                                ]
                            ],
                            [
                                'name' => 'position',
                                'title' => Yii::t('app.c2', 'Position'),
                                'enableError' => true,
                                'type' => \kartik\widgets\TouchSpin::className(),
                                'defaultValue' => 0,
                                'options' => [
                                    'pluginOptions' => [
                                        'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>',
                                        'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                                    ],
                                ]
                            ],
                        ]
                    ],
                ],
            ]
        ]);

        echo Html::beginTag('div', ['class' => 'box-footer']);
        echo Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('app.c2', 'Save'), ['type' => 'button', 'class' => 'btn btn-primary pull-right']);
        // echo Html::a('<i class="fa fa-arrow-left"></i> ' . Yii::t('app.c2', 'Go Back'), ['index'], ['data-pjax' => '0', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Go Back'),]);
        echo Html::a('<i class="fa fa-window-close-o"></i> ' . Yii::t('app.c2', 'Close'), ['index'], ['data-pjax' => '0', 'data-dismiss' => 'modal', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Close'),]);
        echo Html::endTag('div');
        ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php
$js = "";
$js .= "jQuery('.btn.multiple-input-list__btn.js-input-remove').off('click').on('click', function(){
    var itemId = $(this).closest('tr').data('id');
    if(itemId){
       $.ajax({url:'" . Url::toRoute('delete-subitem') . "',data:{id:itemId}}).done(function(result){;}).fail(function(result){alert(result);});
    }
});\n";

$this->registerJs($js);
?>