<?php

use cza\base\models\statics\OperationResult;
use cza\base\widgets\ui\common\grid\GridView;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\ProductionScheduleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Production Schedules');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="well production-schedule-index">

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
                    // yii\bootstrap\ButtonDropdown::widget([
                    //     'label' => "<i class='glyphicon glyphicon-plus'></i> " . Yii::t("app.c2", "Create"),
                    //     'encodeLabel' => false,
                    //     'options' => [
                    //         'class' => 'btn btn-success',
                    //     ],
                    //     'dropdown' => [
                    //         'items' => [
                    //             [
                    //                 'label' => \common\models\c2\statics\ProductionScheduleType::getProductProcessingLabel(),
                    //                 'url' => [
                    //                     'edit',
                    //                 ],
                    //                 'linkOptions' => [
                    //                     'data-pjax' => '0',
                    //                     'class' => 'material'
                    //                 ]
                    //             ],
                    //             [
                    //                 'label' => \common\models\c2\statics\ProductionScheduleType::getMixtureProcessingLabel(),
                    //                 'url' => [
                    //                     '/cl/pam/production-schedule/mixture/edit',
                    //                 ],
                    //                 'linkOptions' => [
                    //                     'data-pjax' => '0'
                    //                 ]
                    //             ],
                    //         ],
                    //     ],
                    // ]) .
                        Html::a('<i class="glyphicon glyphicon-plus"></i>', ['edit'], [
                            'class' => 'btn btn-success',
                            'title' => Yii::t('app.c2', 'Add'),
                            'data-pjax' => '0',
                        ]) . ' ' .
                        // Html::button('<i class="glyphicon glyphicon-remove"></i>', [
                        //     'class' => 'btn btn-danger',
                        //     'title' => Yii::t('app.c2', 'Delete Selected Items'),
                        //     'onClick' => "jQuery(this).trigger('" . OperationEvent::DELETE_BY_IDS . "', {url:'" . Url::toRoute('multiple-delete') . "'});",
                        // ]) . ' ' .
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', Url::current(), [
                            'class' => 'btn btn-default',
                            'id' => 'schedule-refresh',
                            'title' => Yii::t('app.c2', 'Reset Grid')
                        ]),
                ],
                '{export}',
                '{toggleData}',
            ],
            'exportConfig' => [],
            'columns' => [
                // ['class' => 'kartik\grid\CheckboxColumn'],
                // ['class' => 'kartik\grid\SerialColumn'],
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
                // 'type',
                [
                    // 'attribute' => 'type',
                    'label' => Yii::t('app.c2', 'Type'),
                    'value' => function ($model) {
                        return \common\models\c2\statics\ProductionScheduleType::getLabel($model->type);
                    },
                    'filter' => \common\models\c2\statics\ProductionScheduleType::getHashMap('id', 'label')
                ],
                'code',
                'label',
                // 'dept_manager_name',
                // 'financial_name',
                // 'occurrence_date',
                // [
                //     'attribute' => 'occurrence_date',
                //     'value' => function ($model) {
                //         return $model->occurrence_date ? date('Y-m', strtotime($model->occurrence_date)) : '';
                //     },
                // ],
                // 'occomplish_date',
                // 'memo',
                [
                    'attribute' => 'memo',
                    'format' => 'html'
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
                // 'created_by',
                // 'state',
                [
                    'attribute' => 'occurrence_date',
                    'label' => '下单日期',
                    'value' => function ($model) {
                        return $model->occurrence_date ? date('Y-m-d', strtotime($model->occurrence_date)) : '';
                    },
                ],
                [
                    'attribute' => 'estimated_ship_date',
                    'label' => '预计出货日期',
                    'value' => function ($model) {
                        return $model->estimated_ship_date ? date('Y-m-d', strtotime($model->estimated_ship_date)) : '';
                    },
                ],
                [
                    'attribute' => 'actual_ship_date',
                    'label' => '实际出货日期',
                    'value' => function ($model) {
                        return $model->actual_ship_date ? date('Y-m-d', strtotime($model->actual_ship_date)) : '';
                    },

                ],
                [
                    'attribute' => 'state',
                    'value' => function ($model) {
                        return \common\models\c2\statics\ProductionScheduleState::getLabel($model->state);
                    },
                    'filter' => \common\models\c2\statics\ProductionScheduleState::getHashMap('id', 'label')
                ],
                // 'position',
                // 'updated_at',
                // 'created_at',
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
                    'template' => '{update1} {update} {commit} {calculation} {termination} {entrance} 
                    {finish} {send} {check} {checkv2} {print} {delivery-record} {delete}',
                    'visibleButtons' => [
                        'update1' => function ($model) {
                            if ($model->state == \common\models\c2\statics\ProductionScheduleState::INIT) {
                                return false;
                            }
                            return ($model->state != \common\models\c2\statics\ProductionScheduleState::TERMINATION
                                || $model->state != \common\models\c2\statics\ProductionScheduleState::FINISH
                            );
                        },
                        'update' => function ($model) {
                            return ($model->state == \common\models\c2\statics\ProductionScheduleState::INIT);
                        },
                        'calculation' => function ($model) {
                            return ($model->state == \common\models\c2\statics\ProductionScheduleState::INIT);
                        },
                        'commit' => function ($model) {
                            return ($model->state == \common\models\c2\statics\ProductionScheduleState::CALCULATION);
                        },
                        'termination' => function ($model) {
                            return ($model->state == \common\models\c2\statics\ProductionScheduleState::COMMIT);
                        },
                        'entrance' => function ($model) {
                            return ($model->state == \common\models\c2\statics\ProductionScheduleState::COMMIT
                                || $model->state == \common\models\c2\statics\ProductionScheduleState::ALL_SEND);
                        },
                        'send' => function ($model) {
                            return ($model->state == \common\models\c2\statics\ProductionScheduleState::COMMIT
                                || $model->state == \common\models\c2\statics\ProductionScheduleState::ALL_SEND);
                        },
                        'check' => function ($model) {
                            return ($model->state != \common\models\c2\statics\ProductionScheduleState::FINISH);
                        },
                        'checkv2' => function ($model) {
                            return ($model->state != \common\models\c2\statics\ProductionScheduleState::FINISH);
                        },
                        'print' => function ($model) {
                            return ($model->state != \common\models\c2\statics\ProductionScheduleState::FINISH);
                        },
                        'finish' => function ($model) {
                            return ($model->state == \common\models\c2\statics\ProductionScheduleState::COMMIT
                            || $model->state == \common\models\c2\statics\ProductionScheduleState::ALL_SEND);
                        },
                        // 'delivery-record' => function ($model) {
                        //     return ($model->state != \common\models\c2\statics\ProductionScheduleState::FINISH);
                        // },
                    ],
                    'buttons' => [
                        'update1' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-pencil">修改</span>', ['update', 'id' => $model->id], [
                                'title' => Yii::t('app', 'Edit'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-success btn-xs m-1',
                            ]);
                        },
                        'update' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-pencil">修改</span>', ['edit', 'id' => $model->id], [
                                'title' => Yii::t('app', 'Edit'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-success btn-xs m-1',
                            ]);
                        },
                        'calculation' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'Schedule Calculation'), ['calculation', 'id' => $model->id], [
                                'title' => Yii::t('app.c2', 'Schedule Calculation'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-warning btn-xs calculation m-1',
                            ]);
                        },
                        'commit' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'Schedule Commit'), ['commit', 'id' => $model->id], [
                                'title' => Yii::t('app.c2', 'Schedule Commit'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-warning btn-xs commit m-1',
                            ]);
                        },
                        'termination' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'Schedule Termination'), ['termination', 'id' => $model->id], [
                                'title' => Yii::t('app.c2', 'Schedule Termination'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-danger btn-xs termination m-1',
                            ]);
                        },
                        'entrance' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'Enter'), [
                                '/p3s/warehouse-note/production',
                                'id' => $model->id,
                            ], [
                                'title' => Yii::t('app.c2', 'Enter'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-warning btn-xs entrance m-1',
                            ]);
                        },
                        'send' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'Send Production Consumption'), [
                                '/p3s/warehouse-note/mixture-send',
                                'id' => $model->id,
                                'from' => 'pam-send',
                            ], [
                                'title' => Yii::t('app.c2', 'Send Production Consumption'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-info btn-xs m-1',
                            ]);
                        },
                        'delete' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                                'title' => Yii::t('app', 'Info'),
                                'data-pjax' => '0',
                                'class' => 'delete m-1',
                            ]);
                        },
                        // 'check' => function ($url, $model, $key) {
                        //     return Html::a(Yii::t('app.c2', 'Production Consumption Check'), [
                        //         '/cl/pam/production-consumption/default/check',
                        //         'id' => $model->id
                        //     ], [
                        //         'title' => Yii::t('app.c2', 'Production Consumption Check'),
                        //         'data-pjax' => '0',
                        //         'class' => 'btn btn-info btn-xs',
                        //     ]);
                        // },
                        'check' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'Production Consumption Check'), [
                                '/cl/pam/production-consumption/default/check',
                                'id' => $model->id
                            ], [
                                'title' => Yii::t('app.c2', 'Production Consumption Check'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-info btn-xs m-1',
                            ]);
                        },
                        'checkv2' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'Production Consumption Print'), [
                                '/cl/pam/production-consumption/default/check-v2',
                                'schedule_id' => $model->id
                            ], [
                                'title' => Yii::t('app.c2', 'Production Consumption Check'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-info btn-xs m-1',
                            ]);
                        },
                        'delivery-record' => function ($url, $model, $key) {
                            return Html::a('出仓物料记录', [
                                '/cl/pam/production-consumption/default/send-record',
                                'ProductionConsumptionSearch[schedule_id]' => $model->id
                            ], [
                                'title' => '出仓物料记录',
                                'data-pjax' => '0',
                                'class' => 'btn btn-info btn-xs m-1',
                            ]);
                        },
                        // 'print' => function ($url, $model, $key) {
                        //     return Html::a(Yii::t('app.c2', 'Production Consumption Print'), [
                        //         'print',
                        //         'id' => $model->id
                        //     ], [
                        //         'title' => Yii::t('app.c2', 'Production Consumption Print'),
                        //         'data-pjax' => '0',
                        //         'class' => 'btn btn-info btn-xs',
                        //         'target' => '_blank'
                        //     ]);
                        // },
                        // 'view-consumption' => function ($url, $model, $key) {
                        //     return Html::a(Yii::t('app.c2', 'View Consumption'), [
                        //         '/cl/pam/production-consumption/default/check',
                        //         'id' => $model->id
                        //     ], [
                        //         'title' => Yii::t('app.c2', 'View Consumption'),
                        //         'data-pjax' => '0',
                        //         // 'class' => 'btn btn-info btn-xs',
                        //     ]);
                        // },
                        'finish' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'Finish'), [
                                'finish',
                                'id' => $model->id
                            ], [
                                'title' => Yii::t('app.c2', 'Finish'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-success btn-xs finish m-1',
                            ]);
                        },
                    ]
                ],

            ],
        ]); ?>

    </div>


<?php
\yii\bootstrap\Modal::begin([
    'id' => 'termination-edit',
    'size' => 'modal-lg',
    'options' => [
        'tabindex' => false
    ],
]);


$js = "";

$js .= "jQuery(document).off('click', 'a.termination').on('click', 'a.termination', function(e) {
            e.preventDefault();
            jQuery('#termination-edit').modal('show').find('.modal-content').html('" . Yii::t('app.c2', 'Loading...') . "').load(jQuery(e.currentTarget).attr('href'));
        });";

$js .= "jQuery(document).off('click', 'a.calculation').on('click', 'a.calculation', function(e) {
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

$js .= "jQuery(document).off('click', 'a.commit').on('click', 'a.commit', function(e) {
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

$js .= "jQuery(document).off('click', 'a.finish').on('click', 'a.finish', function(e) {
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

$js .= "jQuery(document).off('click', 'a.delete').on('click', 'a.delete', function(e) {
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