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

    <div style="background-color: #d0e9c6;margin-bottom: 20px;">
        <?= $this->render('print', ['model' => $model->receiptNote]) ?>
    </div>


<?php
$form = ActiveForm::begin([
    'action' => ['edit', 'id' => $model->id, 'note_id' => $model->note_id],
    'options' => [
        'id' => $model->getBaseFormName(),
        'data-pjax' => true,
    ]]);
?>

    <div class="<?= $model->getPrefixName('form') ?>">
        <?php if (Yii::$app->session->hasFlash($messageName)): ?>
            <?php if (!$model->hasErrors()) {
                echo InfoBox::widget([
                    'withWrapper' => false,
                    'messages' => Yii::$app->session->getFlash($messageName),
                ]);
                // $this->registerJs("jQuery('#{$model->getPrefixName('grid')}').trigger('" . OperationEvent::REFRESH . "');");
                $this->registerJs("jQuery('#refresh').click();");
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
                    'type' => [
                        'type' => Form::INPUT_DROPDOWN_LIST,
                        'items' => \common\models\c2\statics\WarehouseCommitNoteType::getHashMap('id', 'label'),
                        'options' => [
                            'disabled' => true
                        ]
                    ],
                    'note_code' => [
                        'type' => Form::INPUT_TEXT,
                        'label' => Yii::t('app.c2', 'Receipt Note Code'),
                        'options' => [
                            'value' => $model->isNewRecord ? $model->getNoteByType($model->type)->code : $model->note_code,
                            'readonly' => true,
                            'placeholder' => $model->getAttributeLabel('note_id')
                        ]
                    ],
                    'label' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('label')]],
                    'warehouse_id' => [
                        'type' => Form::INPUT_DROPDOWN_LIST,
                        'items' => \common\models\c2\entity\Warehouse::getHashMap('id', 'name', ['status' => EntityModelStatus::STATUS_ACTIVE]),
                        'options' => [
                            'placeholder' => $model->getAttributeLabel('warehouse_id')
                        ]
                    ],
                    // 'receiver_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('receiver_name')]],

                    // 'state' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\checkbox\CheckboxX', 'options' => [
                    //     'pluginOptions' => ['threeState' => false],
                    // ],],
                    // 'memo' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\vova07\imperavi\Widget', 'options' => [
                    //     'settings' => [
                    //         'minHeight' => 150,
                    //         'buttonSource' => true,
                    //         'lang' => $regularLangName,
                    //         'plugins' => [
                    //             'fontsize',
                    //             'fontfamily',
                    //             'fontcolor',
                    //             'table',
                    //             'textdirection',
                    //             'fullscreen',
                    //         ],
                    //     ]
                    // ],],
                    'memo' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('memo')]],

                    'status' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => EntityModelStatus::getHashMap('id', 'label')],
                    'position' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\touchspin\TouchSpin', 'options' => [
                        'pluginOptions' => [
                            'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>',
                            'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                        ],
                    ],],
                    'note_id' => [
                        'type' => Form::INPUT_HIDDEN,
                        'label' => Yii::t('app.c2', 'Receipt Note Code'),
                        'options' => [
                            // 'disabled' => true,
                            'placeholder' => $model->getAttributeLabel('note_id')
                        ]
                    ],
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
                        'label' => Yii::t('app.c2', 'Add Commit Receipt Items'),
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
                                // [
                                //     'name' => 'label',
                                //     'title' => Yii::t('app.c2', 'Label'),
                                //     'options' => [
                                //     ],
                                // ],
                                [
                                    'name' => 'product_id',
                                    // 'type' => 'dropDownList',
                                    'title' => Yii::t('app.c2', 'Material'),
                                    'enableError' => true,
                                    // 'items' => ['' => Yii::t("app.c2", "Select options ..")] + \common\models\c2\entity\ProductModel::getHashMap('id', 'sku', ['status' => EntityModelStatus::STATUS_ACTIVE]),
                                    'type' => \kartik\select2\Select2::className(),
                                    'options' => [
                                        'data' => \common\models\c2\entity\InventoryReceiptNoteItem::getMixedHashMap('product_id', 'product_name', [
                                            'note_id' => $model->note_id,
                                        ]),
                                    ],
                                ],
                                [
                                    'name' => 'measure_id',
                                    'title' => Yii::t('app.c2', 'Measure'),
                                    'type' => 'dropDownList',
                                    'enableError' => true,
                                    'items' => \common\models\c2\entity\Measure::getHashMap('id', 'name', [
                                        'status' => EntityModelStatus::STATUS_ACTIVE,
                                    ]),
                                ],
                                [
                                    'name' => 'number',
                                    'title' => Yii::t('app.c2', 'Number'),
                                    'enableError' => true,
                                    'defaultValue' => 0,
                                    'options' => [
                                        'type' => 'number',
                                        'min' => 0,
                                        'step' => 0.000001,
                                    ]
                                ],
                                [
                                    'name' => 'memo',
                                    'title' => Yii::t('app.c2', 'Memo'),
                                    'options' => [
                                    ],
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