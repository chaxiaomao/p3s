<?php

use cza\base\widgets\ui\common\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="well order-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'id' => $model->getPrefixName('grid'),
            'pjax' => true,
            'hover' => true,
            'showPageSummary' => true,
            'panel' => ['type' => GridView::TYPE_PRIMARY, 'heading' => Yii::t('app.c2', 'Items')],
            'toolbar' => [
                [
                    'content' =>
                        Html::a('<i class="glyphicon glyphicon-plus"></i>', ['edit'], [
                            'class' => 'btn btn-success',
                            'title' => Yii::t('app.c2', 'Product Order'),
                            'data-pjax' => '0',
                        ]) . ' ' .
                        // Html::button('<i class="glyphicon glyphicon-remove"></i>', [
                        //     'class' => 'btn btn-danger',
                        //     'title' => Yii::t('app.c2', 'Delete Selected Items'),
                        //     'onClick' => "jQuery(this).trigger('" . OperationEvent::DELETE_BY_IDS . "', {url:'" . Url::toRoute('multiple-delete') . "'});",
                        // ]) . ' ' .
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', Url::current(), [
                            'class' => 'btn btn-default',
                            'title' => Yii::t('app.c2', 'Reset Grid')
                        ]),
                ],
                '{export}',
                '{toggleData}',
            ],
            'exportConfig' => [],
            'columns' => [
                ['class' => 'kartik\grid\CheckboxColumn'],
                ['class' => 'kartik\grid\SerialColumn'],
                [
                    'class' => 'kartik\grid\ExpandRowColumn',
                    'expandIcon' => '<span class="fa fa-plus-square-o"></span>',
                    'collapseIcon' => '<span class="fa fa-minus-square-o"></span>',
                    'detailUrl' => Url::toRoute(['detail']),
                    'value' => function ($model, $key, $index, $column) {
                        return GridView::ROW_COLLAPSED;
                    },
                ],
                'id',
                [
                    'attribute' => 'customer_id',
                    'value' => function ($model) {
                        return !is_null($model->customer) ? $model->customer->username : '';
                    },
                    'filterType' => GridView::FILTER_SELECT2,
                    'filter' => ['' => ''] + \common\models\c2\entity\FeUser::getHashMap('id', 'username', ['type' => \common\models\c2\statics\FeUserType::TYPE_CUSTOMER, 'status' => EntityModelStatus::STATUS_ACTIVE])
                ],
                'code',
                // 'label',
                // 'customer_id',
                // 'production_date',
                // 'delivery_date',
                // 'grand_total',
                // 'created_by',
                [
                    'attribute' => 'grand_total',
                    // 'pageSummary' => true,
                    // 'format' => ['decimal', 2],
                ],
                [
                    'attribute' => 'created_by',
                    'value' => function ($model) {
                        return !is_null($model->creator) ? $model->creator->profile->fullname : '';
                    },
                ],
                [
                    'attribute' => 'updated_by',
                    'value' => function ($model) {
                        return !is_null($model->updator) ? $model->updator->profile->fullname : '';
                    },
                ],
                // 'updated_by',
                // 'memo',
                // 'state',
                // 'status',
                // 'position',
                'created_at',
                // 'updated_at',
                [
                    'attribute' => 'state',
                    // 'class' => '\kartik\grid\EditableColumn',
                    // 'editableOptions' => [
                    //     'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    //     'formOptions' => ['action' => Url::toRoute('editColumn')],
                    //     'data' => EntityModelStatus::getHashMap('id', 'label'),
                    //     'displayValueConfig' => EntityModelStatus::getHashMap('id', 'label'),
                    // ],
                    'filter' => \common\models\c2\statics\OrderState::getHashMap('id', 'label'),
                    'value' => function ($model) {
                        return \common\models\c2\statics\OrderState::getLabel($model->state);
                    }
                ],
                // [
                //     'attribute' => 'status',
                //     'class' => '\kartik\grid\EditableColumn',
                //     'editableOptions' => [
                //         'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                //         'formOptions' => ['action' => Url::toRoute('editColumn')],
                //         'data' => EntityModelStatus::getHashMap('id', 'label'),
                //         'displayValueConfig' => EntityModelStatus::getHashMap('id', 'label'),
                //     ],
                //     'filter' => EntityModelStatus::getHashMap('id', 'label'),
                //     'value' => function ($model) {
                //         return $model->getStatusLabel();
                //     }
                // ],
                [
                    'class' => \common\widgets\grid\ActionColumn::className(),
                    'width' => '200px',
                    'template' => '{update} {init} {processing} {solved} {view} {print} {delete}',
                    'visibleButtons' => [
                        'update' => function ($model) {
                            return ($model->state == \common\models\c2\statics\OrderState::INIT);
                        },
                        'cancel' => function ($model) {
                            return (($model->state == \common\models\c2\statics\OrderState::INIT)
                                || ($model->state == \common\models\c2\statics\OrderState::PROCESSING));
                        },
                        'init' => function ($model) {
                            return ($model->state == \common\models\c2\statics\OrderState::CANCEL);
                        },
                        'processing' => function ($model) {
                            return ($model->state == \common\models\c2\statics\OrderState::INIT);
                        },
                        'solved' => function ($model) {
                            return ($model->state == \common\models\c2\statics\OrderState::PROCESSING);
                        },
                        'print' => function ($model) {
                            return ($model->state != \common\models\c2\statics\OrderState::CANCEL);
                        },
                        'stats' => function ($model) {
                            return ($model->state == \common\models\c2\statics\OrderState::PROCESSING);
                        },
                        'view' => function ($model) {
                            return ($model->state == \common\models\c2\statics\OrderState::PROCESSING);
                        },
                    ],
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit', 'id' => $model->id], [
                                'title' => Yii::t('app', 'Info'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-default btn-xs',
                            ]);
                        },
                        'cancel' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'Cancel'), ['cancel', 'id' => $model->id], [
                                'title' => Yii::t('app.c2', 'Cancel'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-danger btn-xs cancel',
                            ]);
                        },
                        'init' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'Init'), ['init', 'id' => $model->id], [
                                'title' => Yii::t('app.c2', 'Init'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-info btn-xs init',
                            ]);
                        },
                        'processing' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'Tune To Process'), ['processing', 'id' => $model->id], [
                                'title' => Yii::t('app.c2', 'Tune To Process'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-warning btn-xs processing',
                            ]);
                        },
                        'solved' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'Solved'), ['solved', 'id' => $model->id], [
                                'title' => Yii::t('app.c2', 'Solved'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-success btn-xs solved',
                            ]);
                        },
                        'print' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-print"></span>', ['view', 'id' => $model->id], [
                                'title' => Yii::t('app.c2', 'Print'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-default btn-xs',
                                'target' => '_blank'
                            ]);
                        },
                        'stats' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-stats"></span>', [
                                '/p3s/order/order-item-consumption', 'OrderItemConsumptionSearch[order_id]' => $model->id
                            ], [
                                'title' => Yii::t('app.c2', 'Stats'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-default btn-xs',
                            ]);
                        },
                        'view' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', [
                                '/p3s/order/order-item', 'OrderItemSearch[order_id]' => $model->id
                            ], [
                                'title' => Yii::t('app.c2', 'View'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-default btn-xs',
                            ]);
                        },
                    ]
                ],

            ],
        ]); ?>

    </div>

<?php


$js = "";

$js .= "jQuery(document).off('click', 'a.init').on('click', 'a.init', function(e) {
                e.preventDefault();
                var lib = window['krajeeDialog'];
                var url = jQuery(e.currentTarget).attr('href');
                lib.confirm('" . Yii::t('app.c2', 'Are you sure?') . "', function (result) {
                    if (!result) {
                        return;
                    }
                    jQuery.ajax({
                            url: url,
                            success: function(data) {
                                var lifetime = 6500;
                                if(data._meta.result == '" . cza\base\models\statics\OperationResult::SUCCESS . "'){
                                    jQuery('#{$model->getPrefixName('grid')}').trigger('" . OperationEvent::REFRESH . "');
                                }
                                else{
                                  lifetime = 16500;
                                }
                                jQuery.msgGrowl ({
                                        type: data._meta.type, 
                                        title: '" . Yii::t('cza', 'Tips') . "',
                                        text: data._meta.message,
                                        position: 'top-center',
                                        lifetime: lifetime,
                                });
                            },
                            error :function(data){alert(data._meta.message);}
                    });
                });
            });";

$js .= "jQuery(document).off('click', 'a.cancel').on('click', 'a.cancel', function(e) {
                e.preventDefault();
                var lib = window['krajeeDialog'];
                var url = jQuery(e.currentTarget).attr('href');
                lib.confirm('" . Yii::t('app.c2', 'Are you sure?') . "', function (result) {
                    if (!result) {
                        return;
                    }
                    
                    jQuery.ajax({
                            url: url,
                            success: function(data) {
                                var lifetime = 6500;
                                if(data._meta.result == '" . cza\base\models\statics\OperationResult::SUCCESS . "'){
                                    jQuery('#{$model->getPrefixName('grid')}').trigger('" . OperationEvent::REFRESH . "');
                                }
                                else{
                                  lifetime = 16500;
                                }
                                jQuery.msgGrowl ({
                                        type: data._meta.type, 
                                        title: '" . Yii::t('cza', 'Tips') . "',
                                        text: data._meta.message,
                                        position: 'top-center',
                                        lifetime: lifetime,
                                });
                            },
                            error :function(data){alert(data._meta.message);}
                    });
                });
            });";

$js .= "jQuery(document).off('click', 'a.processing').on('click', 'a.processing', function(e) {
                e.preventDefault();
                var lib = window['krajeeDialog'];
                var url = jQuery(e.currentTarget).attr('href');
                lib.confirm('" . Yii::t('app.c2', 'Are you sure?') . "', function (result) {
                    if (!result) {
                        return;
                    }
                    
                    jQuery.ajax({
                            url: url,
                            success: function(data) {
                                var lifetime = 6500;
                                if(data._meta.result == '" . cza\base\models\statics\OperationResult::SUCCESS . "'){
                                    jQuery('#{$model->getPrefixName('grid')}').trigger('" . OperationEvent::REFRESH . "');
                                }
                                else{
                                  lifetime = 16500;
                                }
                                jQuery.msgGrowl ({
                                        type: data._meta.type, 
                                        title: '" . Yii::t('cza', 'Tips') . "',
                                        text: data._meta.message,
                                        position: 'top-center',
                                        lifetime: lifetime,
                                });
                            },
                            error :function(data){alert(data._meta.message);}
                    });
                });
            });";


$js .= "jQuery(document).off('click', 'a.solved').on('click', 'a.solved', function(e) {
                e.preventDefault();
                var lib = window['krajeeDialog'];
                var url = jQuery(e.currentTarget).attr('href');
                lib.confirm('" . Yii::t('app.c2', 'Are you sure?') . "', function (result) {
                    if (!result) {
                        return;
                    }
                    
                    jQuery.ajax({
                            url: url,
                            success: function(data) {
                                var lifetime = 6500;
                                if(data._meta.result == '" . cza\base\models\statics\OperationResult::SUCCESS . "'){
                                    jQuery('#{$model->getPrefixName('grid')}').trigger('" . OperationEvent::REFRESH . "');
                                }
                                else{
                                  lifetime = 16500;
                                }
                                jQuery.msgGrowl ({
                                        type: data._meta.type, 
                                        title: '" . Yii::t('cza', 'Tips') . "',
                                        text: data._meta.message,
                                        position: 'top-center',
                                        lifetime: lifetime,
                                });
                            },
                            error :function(data){alert(data._meta.message);}
                    });
                });
            });";

$js .= "$.fn.modal.Constructor.prototype.enforceFocus = function(){};";   // fix select2 widget input-bug in popup

$this->registerJs($js);
?>