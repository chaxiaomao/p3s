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
        <?php echo $this->render('print', ['model' => $model->deliveryNote]) ?>
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
                $this->registerJs("jQuery('#{$model->getPrefixName('grid')}').trigger('" . OperationEvent::REFRESH . "');");
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
                    'memo' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('memo')]],

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
                            'placeholder' => $model->getAttributeLabel('note_id')
                        ]
                    ],
                ]
            ]);

            ?>
            <p style="color: red">产品总量留空则自动计算。</p>
            <p style="color: red">提示：先保存一次得出产品总量，再分配生产库存占比。</p>
            <?php

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
                                        'data' => \common\models\c2\entity\InventoryDeliveryNoteItem::getMixedHashMap('id', 'sku', [
                                            'note_id' => $model->note_id,
                                        ]),
                                        'pluginEvents' => [
                                            'change' => "function() {
                                                $.post('" . Url::toRoute(['product-addition']) . "', {'depdrop_all_params[product_id]':$(this).val(),'depdrop_parents[]':$(this).val()}, function(data) {
                                                    if(data.output !== undefined) {
                                                        $('select#combination-{multiple_index_{$multipleItemsId}}').empty();
                                                        $('select#package-{multiple_index_{$multipleItemsId}}').empty();
                                                        $.each(data.output.combination, function(key, item){
                                                                $('select#combination-{multiple_index_{$multipleItemsId}}').append('<option value=' + item.id + '>' + item.name + '</option>');
                                                            });
                                                        $.each(data.output.package, function(key, item){
                                                            $('select#package-{multiple_index_{$multipleItemsId}}').append('<option value=' + item.id + '>' + item.name + '</option>');
                                                        });
                                                    }
                                                })
                                            }",
                                        ],
                                    ],
                                ],
                                [
                                    'name' => 'combination_id',
                                    'type' => 'dropDownList',
                                    // 'items' => $model->isNewRecord ? [] : \common\models\c2\entity\ProductCombinationModel::getHashMap('id', 'label'),
                                    'items' => $model->isNewRecord ? [] : function ($data) {
                                        if (is_object($data)) {
                                            return $data->product->getCombinationOptionList();
                                        }
                                        return [];
                                    },
                                    'title' => Yii::t('app.c2', 'Product Combination'),
                                    'options' => [
                                        'id' => "combination-{multiple_index_{$multipleItemsId}}",
                                    ],
                                ],
                                [
                                    'name' => 'package_id',
                                    'type' => 'dropDownList',
                                    'items' => $model->isNewRecord ? [] : function ($data) {
                                        if (is_object($data)) {
                                            return $data->product->getPackageOptionList();
                                        }
                                        return [];
                                    },
                                    'title' => Yii::t('app.c2', 'Product Package'),
                                    'options' => [
                                        'id' => "package-{multiple_index_{$multipleItemsId}}",
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
                                    'name' => 'pieces',
                                    'title' => Yii::t('app.c2', 'Pieces'),
                                    'enableError' => true,
                                    'options' => [
                                        'type' => 'number',
                                        'min' => 0,
                                    ]
                                ],
                                [
                                    'name' => 'product_sum',
                                    'title' => Yii::t('app.c2', 'Product Sum'),
                                    'enableError' => true,
                                    'options' => [
                                        'type' => 'number',
                                        'min' => 0,
                                    ]
                                ],
                                [
                                    'name' => 'produce_number',
                                    'title' => Yii::t('app.c2', 'Produce Number'),
                                    'enableError' => true,
                                    'options' => [
                                        'type' => 'number',
                                        'min' => 0,
                                    ]
                                ],
                                [
                                    'name' => 'stock_number',
                                    'title' => Yii::t('app.c2', 'Stock Number'),
                                    'enableError' => true,
                                    'options' => [
                                        'type' => 'number',
                                        'min' => 0,
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