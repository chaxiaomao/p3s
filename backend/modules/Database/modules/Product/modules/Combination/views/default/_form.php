<?php

use common\models\c2\entity\Product;
use cza\base\models\statics\OperationEvent;
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
                $this->registerJs(
                // "jQuery('#combination-grid').trigger('" . OperationEvent::REFRESH . "');"
                    "jQuery('#combination-refresh').click();"
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
                    'stock' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => $model->getAttributeLabel('stock')]],
                    'status' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => EntityModelStatus::getHashMap('id', 'label')],
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
                    'position' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\touchspin\TouchSpin', 'options' => [
                        'pluginOptions' => [
                            'buttondown_txt' => '<i class="glyphicon glyphicon-minus-sign"></i>',
                            'buttonup_txt' => '<i class="glyphicon glyphicon-plus-sign"></i>',
                        ],
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
                        'label' => Yii::t('app.c2', 'Add Product Combination Items'),
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
                                    'name' => 'label',
                                    'title' => Yii::t('app.c2', 'Label'),
                                    'options' => [
                                    ],
                                ],
                                // [
                                //     'name' => 'product_id',
                                //     // 'type' => 'dropDownList',
                                //     'title' => Yii::t('app.c2', 'Material'),
                                //     'enableError' => true,
                                //     // 'items' => ['' => Yii::t("app.c2", "Select options ..")] + \common\models\c2\entity\ProductModel::getHashMap('id', 'sku', ['status' => EntityModelStatus::STATUS_ACTIVE]),
                                //     'type' => \kartik\select2\Select2::className(),
                                //     'options' => [
                                //         'data' => \backend\models\c2\entity\Material::getMixedOptions('id', 'sku', [
                                //             'type' => \common\models\c2\statics\ProductType::TYPE_MATERIAL,
                                //             'status' => EntityModelStatus::STATUS_ACTIVE
                                //         ]),
                                //     ],
                                // ],
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
                                                $text = $product['name'];
                                            }
                                        }
                                        return [
                                            'initValueText' => $text,
                                            'pluginOptions' => [
                                                'width' => '400px',
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
                                                                type: 1,
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
                                [
                                    'name' => 'need_number',
                                    'title' => Yii::t('app.c2', 'Need Number'),
                                    'enableError' => true,
                                    'defaultValue' => '1',
                                    'options' => [
                                        // 'type' => 'number',
                                        'min' => '0',
                                        'step' => 'any',
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
$js .= "$.fn.modal.Constructor.prototype.enforceFocus = function(){};";   // fix select2 widget input-bug in popup

$this->registerJs($js);
?>