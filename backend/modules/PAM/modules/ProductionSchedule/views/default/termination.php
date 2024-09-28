<?php

use unclead\multipleinput\MultipleInput;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use cza\base\widgets\ui\adminlte2\InfoBox;
use cza\base\models\statics\EntityModelStatus;
use yii\helpers\Url;
use yii\widgets\Pjax;

$regularLangName = \Yii::$app->czaHelper->getRegularLangName();
$messageName = $model->getMessageName();
?>

<?php Pjax::begin(['id' => $model->getDetailPjaxName(), 'formSelector' => $model->getBaseFormName(true), 'enablePushState' => false, 'clientOptions' => [
    'skipOuterContainers' => true
]]) ?>

<?php
$form = ActiveForm::begin([
    'action' => ['termination', 'id' => $model->schedule_id],
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
                "jQuery('#schedule-refresh').click();"
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

        <p style="color: red">提示1：请修改已生成的产品数量，再点击终止按钮！<br>改操作会扣除已生产产品数量所使用的物料库存，不扣除所需包装物料库存。</p>
        <p style="color: red">提示2：这是一次性操作，请确认好数据再提交终止。</p>
        <?php
        $multipleItemsId = $model->getPrefixName('produced_items');
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'produced_items' => [
                    'type' => Form::INPUT_WIDGET,
                    'label' => Yii::t('app.c2', 'Add Produced Items'),
                    'widgetClass' => unclead\multipleinput\MultipleInput::className(),
                    'options' => [
                        'id' => $multipleItemsId,
                        'data' => $model->produced_items,
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
                                'name' => 'product_id',
                                // 'type' => 'dropDownList',
                                'title' => Yii::t('app.c2', 'Product'),
                                'enableError' => true,
                                // 'items' => ['' => Yii::t("app.c2", "Select options ..")] + \common\models\c2\entity\ProductModel::getHashMap('id', 'sku', ['status' => EntityModelStatus::STATUS_ACTIVE]),
                                'type' => \kartik\select2\Select2::className(),
                                'options' => [
                                    // 'data' => \common\models\c2\entity\Product::getMixedHashMap('id', 'sku', [
                                    //     'type' => \common\models\c2\statics\ProductType::TYPE_PRODUCT,
                                    //     'status' => EntityModelStatus::STATUS_ACTIVE
                                    // ]),
                                    'data' => ['' => 'selecting ...'] + \common\models\c2\entity\ProductionScheduleItem::getHashMap('product_id', 'product_sku', [
                                            'schedule_id' => $model->schedule_id
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
                                'items' => function ($data) {
                                    if (is_object($data)) {
                                        return $data->product->getCombinationOptionList();
                                    }
                                    return [];
                                },
                                'title' => Yii::t('app.c2', 'Product Combination'),
                                'options' => [
                                    'id' => "combination-{multiple_index_{$multipleItemsId}}",
                                    'onchange' => "function() {
                                                console.log(1)
                                                $.post('" . Url::toRoute(['product-addition']) . "', {'depdrop_all_params[product_id]':$(this).val(),'depdrop_parents[]':$(this).val()}, function(data) {
                                                    if(data.output !== undefined) {
                                                    }
                                                })
                                            }",
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
                                'name' => 'production_sum',
                                'title' => Yii::t('app.c2', 'Produced Sum'),
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

        $multipleItemsId = $model->getPrefixName('back_mixture_items');
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'back_mixture_items' => [
                    'type' => Form::INPUT_WIDGET,
                    'label' => Yii::t('app.c2', 'Add Back Mixture Items'),
                    'widgetClass' => unclead\multipleinput\MultipleInput::className(),
                    'options' => [
                        'id' => $multipleItemsId,
                        'data' => $model->back_mixture_items,
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
                                'name' => 'product_id',
                                // 'type' => 'dropDownList',
                                'title' => Yii::t('app.c2', 'Material'),
                                'enableError' => true,
                                // 'items' => ['' => Yii::t("app.c2", "Select options ..")] + \common\models\c2\entity\ProductModel::getHashMap('id', 'sku', ['status' => EntityModelStatus::STATUS_ACTIVE]),
                                'type' => \kartik\select2\Select2::className(),
                                'options' => [
                                    'data' => ['' => 'selecting ...'] + \common\models\c2\entity\ProductionConsumption::getHashMap('need_product_id', 'need_product_name', [
                                            'schedule_id' => $model->schedule_id
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
                                'name' => 'back_mixture_sum',
                                'title' => Yii::t('app.c2', 'Back Mixture Sum'),
                                'enableError' => true,
                                'options' => [
                                    'type' => 'number',
                                    'min' => 0,
                                ]
                            ],
                        ]
                    ],
                ],
            ]
        ]);

        echo Html::beginTag('div', ['class' => 'box-footer']);
        echo Html::submitButton('<i class="fa fa-save"></i> ' . Yii::t('app.c2', 'Schedule Termination'), ['type' => 'button', 'class' => 'btn btn-primary pull-right']);
        echo Html::a('<i class="fa fa-window-close-o"></i> ' . Yii::t('app.c2', 'Close'), ['index'], ['data-pjax' => '0', 'data-dismiss' => 'modal', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Close'),]);
        echo Html::endTag('div');
        ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php Pjax::end() ?>
