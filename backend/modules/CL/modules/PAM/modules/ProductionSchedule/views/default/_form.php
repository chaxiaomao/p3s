<?php

use common\models\c2\entity\Product;
use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use cza\base\widgets\ui\adminlte2\InfoBox;
use cza\base\models\statics\EntityModelStatus;
use yii\helpers\Url;
use yii\web\JsExpression;

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
                    'type' => [
                        'type' => Form::INPUT_DROPDOWN_LIST,
                        'items' => \common\models\c2\statics\ProductionScheduleType::getHashMap('id', 'label'),
                        'options' => [
                            'disabled' => true,
                        ],
                    ],
                    'code' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('code')]],

                    'label' => [
                        'type' => Form::INPUT_TEXT,
                        'label' => '标签<span class="text-red">（CL订单需要标注“CL/CL-”前缀）</span>',
                        'options' => [
                            // 'placeholder' => $model->getAttributeLabel('label')
                            'placeholder' => '如：CL-XXX'
                        ]
                    ],
                    'barcode' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('barcode')]],
                    'area' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('area')]],

                    'dept_manager_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('dept_manager_name')]],
                    'financial_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('financial_name')]],
                    'occurrence_date' => [
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => '\kartik\widgets\DateTimePicker',
                        'label' => '下单时间<span class="text-red">（CL订单需要填写日期）</span>',
                        'options' => [
                            'options' => [
                                'placeholder' => Yii::t('app.c2', 'Date Time...')
                            ],
                            'pluginOptions' => [
                                'format' => 'yyyy-mm-dd',
                                'minView' => 2,
                                'startView' => 2,
                                'autoclose' => true
                            ],
                        ],
                    ],
                    'estimated_ship_date' => [
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => '\kartik\widgets\DateTimePicker',
                        'label' => '预计出货时间<span class="text-red">（CL订单需要填写日期）</span>',
                        'options' => [
                            'options' => [
                                'placeholder' => Yii::t('app.c2', 'Date Time...')
                            ],
                            'pluginOptions' => [
                                'format' => 'yyyy-mm-dd',
                                'minView' => 2,
                                'startView' => 2,
                                'autoclose' => true
                            ],
                        ],
                    ],
                    'actual_ship_date' => [
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => '\kartik\widgets\DateTimePicker',
                        'label' => '实际出货时间<span class="text-red">（CL订单需要填写日期）</span>',
                        'options' => [
                            'options' => [
                                'placeholder' => Yii::t('app.c2', 'Date Time...')
                            ],
                            'pluginOptions' => [
                                'format' => 'yyyy-mm-dd',
                                'minView' => 2,
                                'startView' => 2,
                                'autoclose' => true
                            ],
                        ],
                    ],
                    'accomplish_date' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\widgets\DateTimePicker', 'options' => [
                        'options' => ['placeholder' => Yii::t('app.c2', 'Date Time...')], 'pluginOptions' => ['format' => 'yyyy-mm-dd hh:ii:ss', 'autoclose' => true],
                    ],],
                    // 'memo' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('memo')]],
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
            <!--            <p style="color: red">产品总量留空则自动计算。</p>-->
            <?php
            $multipleItemsId = $model->getPrefixName('items');
            echo Form::widget([
                'model' => $model,
                'form' => $form,
                'columns' => 1,
                'attributes' => [
                    'items' => [
                        'type' => Form::INPUT_WIDGET,
                        'label' => Yii::t('app.c2', 'Add Production Schedule Items'),
                        'widgetClass' => unclead\multipleinput\MultipleInput::className(),
                        'options' => [
                            'id' => $multipleItemsId,
                            'data' => $model->items,
                            //  'max' => 4,
                            'allowEmptyList' => true,
                            'rowOptions' => function ($model, $index, $context) use ($multipleItemsId) {
                                return ['id' => "row{multiple_index_{$multipleItemsId}}", 'data-id' => $model ? $model['id'] : ''];
                            },
                            'columns' => [
                                [
                                    'name' => 'id',
                                    'type' => 'hiddenInput',
                                ],
                                [
                                    'name' => 'product_id',
                                    // 'type' => 'dropDownList',
                                    'title' => Yii::t('app.c2', 'Product'),
                                    'enableError' => true,
                                    // 'items' => ['' => Yii::t("app.c2", "Select options ..")] + \common\models\c2\entity\ProductModel::getHashMap('id', 'sku', ['status' => EntityModelStatus::STATUS_ACTIVE]),
                                    'type' => \kartik\select2\Select2::className(),
                                    'value' => function ($data) {
                                        return $data ? $data['product_id'] : '';
                                    },
                                    'options' => function ($data) use ($multipleItemsId) {
                                        $text = '';
                                        if (!empty($data['product_id'])) {
                                            $product = Product::find()
                                                ->select('id,name,sku')
                                                ->where(['id' => $data['product_id']])
                                                ->asArray()
                                                ->one();
                                            if ($product) {
                                                $text = $product['sku'] . '(' . $product['name'] . ')';
                                            }
                                        }
                                        return [
                                            'initValueText' => $text,
                                            'pluginOptions' => [
                                                'width' => '280px',
                                                // 'allowClear' => true,
                                                'minimumInputLength' => 2,
                                                'ajax' => [
                                                    'url' => Url::to(['/api/product-search']),
                                                    'dataType' => 'json',
                                                    'delay' => 400,
                                                    'data' => new JsExpression(
                                                        'function(params){
                                                        return {
                                                                keyword: params.term,
                                                                isCL: false,
                                                            };
                                                        }'
                                                    ),
                                                    'processResults' => new JsExpression(
                                                        'function(data){
                                                        return {
                                                                results:data.results
                                                            };
                                                        }'
                                                    ),
                                                ],
                                            ],
                                            'pluginEvents' => [
                                                'change' => "function() {
                                                let row = $(this).closest('tr');

                                                $.post('" . Url::toRoute(['product-addition']) . "', {
                                                    'depdrop_all_params[product_id]': $(this).val(),
                                                    'depdrop_parents[]': $(this).val(),
                                                    'customer_id': $('#order-customer_id').val()
                                                }, function(data) {
                                            
                                                    row.find('[id^=last_price-]')
                                                        .val(data.output.last_price);
                                            
                                                    if(data.output !== undefined) {
                                            
                                                        let combination = row.find(
                                                            '[id^=combination-]'
                                                        );
                                            
                                                        let packageSelect = row.find(
                                                            '[id^=package-]'
                                                        );
                                           
                                                        combination.empty();
                                            
                                                        packageSelect.empty();
                                            
                                                        $.each(
                                                            data.output.combination,
                                                            function(key,item){
                                                                combination.append(
                                                                    '<option value=\"'+item.id+'\">'
                                                                    + item.name +
                                                                    '</option>'
                                                                );
                                                            }
                                                        );
                                            
                                                        $.each(
                                                            data.output.package,
                                                            function(key,item){
                                                                packageSelect.append(
                                                                    '<option value=\"'+item.id+'\">'
                                                                    + item.name +
                                                                    '</option>'
                                                                );
                                                            }
                                                        );
                                                    }
                                                });

                                            }",
                                            ],
                                        ];

                                    },
                                ],
                                // [
                                //     'name' => 'product_id',
                                //     // 'type' => 'dropDownList',
                                //     'title' => Yii::t('app.c2', 'Product'),
                                //     'enableError' => true,
                                //     // 'items' => ['' => Yii::t("app.c2", "Select options ..")] + \common\models\c2\entity\ProductModel::getHashMap('id', 'sku', ['status' => EntityModelStatus::STATUS_ACTIVE]),
                                //     'type' => \kartik\select2\Select2::className(),
                                //     'options' => [
                                //         'data' => \common\models\c2\entity\Product::getMixedHashMap('id', 'sku', [
                                //             'type' => \common\models\c2\statics\ProductType::TYPE_PRODUCT,
                                //             'status' => EntityModelStatus::STATUS_ACTIVE
                                //         ]),
                                //         'pluginEvents' => [
                                //             'change' => "function() {
                                //                 $.post('" . Url::toRoute(['product-addition']) . "', {'depdrop_all_params[product_id]':$(this).val(),'depdrop_parents[]':$(this).val()}, function(data) {
                                //                     if(data.output !== undefined) {
                                //                         $('#productionschedule-label').val(data.output.product_name);
                                //                         $('select#combination-{multiple_index_{$multipleItemsId}}').empty();
                                //                         $('select#package-{multiple_index_{$multipleItemsId}}').empty();
                                //                         $.each(data.output.combination, function(key, item){
                                //                                 $('select#combination-{multiple_index_{$multipleItemsId}}').append('<option value=' + item.id + '>' + item.name + '</option>');
                                //                             });
                                //                         $.each(data.output.package, function(key, item){
                                //                             $('select#package-{multiple_index_{$multipleItemsId}}').append('<option value=' + item.id + '>' + item.name + '</option>');
                                //                         });
                                //                     }
                                //                 })
                                //             }",
                                //         ],
                                //     ],
                                // ],
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
                                        'onchange' => "function() {
                                                $.post('" . Url::toRoute(['product-addition']) . "', {'depdrop_all_params[product_id]':$(this).val(),'depdrop_parents[]':$(this).val()}, function(data) {
                                                    if(data.output !== undefined) {
                                                    }
                                                })
                                            }",
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
                                    'name' => 'production_sum',
                                    'title' => Yii::t('app.c2', 'Produce Sum'),
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