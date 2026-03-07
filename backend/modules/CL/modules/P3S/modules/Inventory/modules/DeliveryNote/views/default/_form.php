<?php

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
                    'type' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => \common\models\c2\statics\InventoryDeliveryType::getHashMap('id', 'label')],
                    'code' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('code')]],
                    'label' => [
                        'label' => Yii::t('app.c2', 'Receipt Company'),
                        'type' => Form::INPUT_TEXT,
                        'options' => [
                            'id' => 'address',
                            'placeholder' => Yii::t('app.c2', 'Receipt Company')
                        ]
                    ],
                    'warehouse_id' => [
                        'type' => Form::INPUT_DROPDOWN_LIST,
                        'items' => \common\models\c2\entity\Warehouse::getHashMap('id', 'name', [
                            'status' => EntityModelStatus::STATUS_ACTIVE
                        ]),
                        'options' => [
                            'placeholder' => $model->getAttributeLabel('warehouse_id')
                        ]
                    ],
                    // 'sales_order_id' => [
                    //     'type' => Form::INPUT_WIDGET,
                    //     'widgetClass' => \kartik\select2\Select2::className(),
                    //     'options' => [
                    //         'data' => ['' => 'Select ...'] + \common\models\c2\entity\Order::getHashMap('id', 'code', [
                    //                 'state' => \common\models\c2\statics\OrderState::PROCESSING
                    //             ]),
                    //         // 'placeholder' => $model->getAttributeLabel('sales_order_id')
                    //     ]
                    // ],
                    'customer_id' => [
                        // 'type' => Form::INPUT_DROPDOWN_LIST,
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => \kartik\select2\Select2::className(),
                        // 'items' => ['' => 'Select ...'] + \common\models\c2\entity\FeUser::getHashMap('id', 'username', [
                        //         'status' => EntityModelStatus::STATUS_ACTIVE,
                        //         'type' => \common\models\c2\statics\FeUserType::TYPE_CUSTOMER
                        //     ]),
                        'options' => [
                            'data' => ['' => 'Select ...'] + \common\models\c2\entity\FeUser::getHashMap('id', 'username', [
                                    'status' => EntityModelStatus::STATUS_ACTIVE,
                                    'type' => \common\models\c2\statics\FeUserType::TYPE_CUSTOMER
                                ]),
                            'pluginEvents' => [
                                'change' => "function(){
                                    $.post('" . Url::toRoute(['orders']) . "', {'depdrop_all_params[customer_id]':$(this).val(),'depdrop_parents[]':$(this).val()}, function(data){
                                    if(data.output !== undefined){
                                        $('select#order_list').empty();
                                        $.each(data.output, function(key, item){
                                            $('select#order_list').append('<option value=' + item.id + '>' + item.code + '</option>');
                                        });
                                    }
                                });" . "$.post('" . Url::toRoute(['profile']) . "', {'depdrop_all_params[customer_id]':$(this).val(),'depdrop_parents[]':$(this).val()}, function(data){
                                    if(data.output !== undefined){
                                       $('#address').val(data.output.address);
                                    }
                                });
                                }"
                            ],
                            // 'placeholder' => $model->getAttributeLabel('customer_id'),
                            // 'onchange' => new \yii\web\JsExpression("$.post('" . Url::toRoute(['orders']) . "', {'depdrop_all_params[customer_id]':$(this).val(),'depdrop_parents[]':$(this).val()}, function(data){
                            //     if(data.output !== undefined){
                            //         $('select#order_list').empty();
                            //         $.each(data.output, function(key, item){
                            //             $('select#order_list').append('<option value=' + item.id + '>' + item.code + '</option>');
                            //         });
                            //     }
                            // });" . "$.post('" . Url::toRoute(['profile']) . "', {'depdrop_all_params[customer_id]':$(this).val(),'depdrop_parents[]':$(this).val()}, function(data){
                            //     if(data.output !== undefined){
                            //        $('#address').val(data.output.address);
                            //     }
                            // });")
                        ]
                    ],
                    'sales_order_id' => [
                        'type' => Form::INPUT_DROPDOWN_LIST,
                        'items' => $model->isNewRecord ? [] : $model->customer->getProcessingOrderOptions(),
                        'options' => [
                            'id' => 'order_list',
                        ]
                    ],
                    'occurrence_date' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\widgets\DateTimePicker', 'options' => [
                        'options' => ['placeholder' => Yii::t('app.c2', 'Date Time...')], 'pluginOptions' => ['format' => 'yyyy-mm-dd hh:ii:ss', 'autoclose' => true],
                    ],],
                    'grand_total' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => Yii::t('app.c2', 'Empty this input will auto calculate.')]],
                    'contact_man' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('contact_man')]],
                    'cs_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('cs_name')]],
                    'sender_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('sender_name')]],
                    'financial_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('financial_name')]],
                    'payment_method' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('payment_method')]],
                    'delivery_method' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('delivery_method')]],
                    // 'remote_ip' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('remote_ip')]],
                    // 'is_audited' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\checkbox\CheckboxX', 'options' => [
                    //     'pluginOptions' => ['threeState' => false],
                    // ],],
                    // 'audited_by' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('audited_by')]],
                    // 'state' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\checkbox\CheckboxX', 'options' => [
                    //     'pluginOptions' => ['threeState' => false],
                    // ],],
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
                'columns' => 1,
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

            ?>

            <?php
            if (!$model->isNewRecord) {
                echo '<p style="color: red">产品总量留空则自动计算。</p>
                        <p style="color: red">小计留空则自动计算。</p>';
                $multipleItemsId = $model->getPrefixName('items');
                echo Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'items' => [
                            'type' => Form::INPUT_WIDGET,
                            'label' => Yii::t('app.c2', 'Add Order Items'),
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
                                            // 'data' => \common\models\c2\entity\Product::getMixedHashMap('id', 'sku', [
                                            //     'type' => \common\models\c2\statics\ProductType::TYPE_PRODUCT,
                                            //     'status' => EntityModelStatus::STATUS_ACTIVE
                                            // ]),
                                            'data' => \common\models\c2\entity\OrderItem::getMixedHashMap('', '', [
                                                'order_id' => $model->sales_order_id
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
                                        'defaultValue' => 0,
                                        'options' => [
                                            'type' => 'number',
                                            'min' => 0,
                                        ]
                                    ],
                                    [
                                        'name' => 'product_sum',
                                        'title' => Yii::t('app.c2', 'Product Sum'),
                                        'enableError' => true,
                                        'defaultValue' => '0',
                                        'options' => [
                                            'type' => 'number',
                                            'min' => 0,
                                        ]
                                    ],
                                    [
                                        'name' => 'price',
                                        'title' => Yii::t('app.c2', 'Price'),
                                        'enableError' => true,
                                        'defaultValue' => '0.000',
                                        'options' => [
                                            'type' => 'number',
                                            'step' => 'any',
                                            'min' => 0,
                                        ]
                                    ],
                                    [
                                        'name' => 'subtotal',
                                        'title' => Yii::t('app.c2', 'Subtotal'),
                                        'enableError' => true,
                                        // 'defaultValue' => '0.00',
                                        'options' => [
                                            'type' => 'number',
                                            'step' => 'any',
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
                                        'name' => 'is_auto_number',
                                        'title' => Yii::t('app.c2', 'Is Auto Number'),
                                        'enableError' => true,
                                        'defaultValue' => 1,
                                        'type' => \kartik\checkbox\CheckboxX::className(),
                                        'options' => [
                                            'pluginOptions' => ['threeState' => false],
                                        ]
                                    ],
                                    // [
                                    //     'name' => 'position',
                                    //     'title' => Yii::t('app.c2', 'Position'),
                                    //     'enableError' => true,
                                    //     'type' => \kartik\widgets\TouchSpin::className(),
                                    //     'defaultValue' => 0,
                                    //     'options' => [
                                    //         'pluginOptions' => [
                                    //             'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>',
                                    //             'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                                    //         ],
                                    //     ]
                                    // ],
                                ]
                            ],
                        ],
                    ]
                ]);
            }

            echo Html::beginTag('div', ['class' => 'box-footer']);
            echo Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('app.c2', 'Save'), ['type' => 'button', 'class' => 'btn btn-primary pull-right']);
            echo Html::a('<i class="fa fa-arrow-left"></i> ' . Yii::t('app.c2', 'Go Back'), ['index'], ['data-pjax' => '0', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Go Back'),]);
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