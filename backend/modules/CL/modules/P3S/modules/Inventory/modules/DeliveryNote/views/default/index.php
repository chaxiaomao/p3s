<?php

use cza\base\widgets\ui\common\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\InventoryDeliveryNoteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Inventory Delivery Notes');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="well inventory-delivery-note-index">

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
                // 'type',
                'code',
                // 'label',
                // 'warehouse_id',
                // [
                //     'attribute' => 'warehouse_id',
                //     'value' => function ($model) {
                //         return !is_null($model->warehouse) ? $model->warehouse->name : '';
                //     }
                // ],
                // 'sales_order_id',
                [
                    // 'attribute' => 'customer_id',
                    'label' => Yii::t('app.c2', 'Customer'),
                    'value' => function ($model) {
                        return !is_null($model->customer) ? $model->customer->username : '';
                    },
                    // 'filterType' => GridView::FILTER_SELECT2,
                    // 'filter' => ['' => ''] + \common\models\c2\entity\FeUser::getHashMap('id', 'username', ['type' => \common\models\c2\statics\FeUserType::TYPE_CUSTOMER, 'status' => EntityModelStatus::STATUS_ACTIVE])
                ],
                // 'customer_id',
                // 'occurrence_date',
                // 'grand_total',
                // 'contact_man',
                // 'cs_name',
                // 'sender_name',
                // 'financial_name',
                // 'payment_method',
                // 'delivery_method',
                // 'memo:ntext',
                [
                    'attribute' => 'memo',
                    'format' => 'html',
                ],
                // 'remote_ip',
                // 'is_audited',
                // 'audited_by',
                // 'updated_by',
                // 'created_by',
                [
                    'attribute' => 'created_by',
                    'value' => function ($model) {
                        return !is_null($model->creator) ? $model->creator->username : '';
                    }
                ],
                [
                    'attribute' => 'updated_by',
                    'value' => function ($model) {
                        return !is_null($model->updator) ? $model->updator->username : '';
                    },
                ],
                // 'state',
                // 'status',
                // 'position',
                // 'updated_at',
                'created_at',
                [
                    'attribute' => 'state',
                    'filter' => \common\models\c2\statics\InventoryDeliveryNoteState::getHashMap('id', 'label'),
                    'value' => function ($model) {
                        return \common\models\c2\statics\InventoryDeliveryNoteState::getLabel($model->state);
                    }
                ],
                [
                    'class' => \common\widgets\grid\ActionColumn::className(),
                    'width' => '200px',
                    'template' => '{update} {init} {cancel} {send} {solved} {print} {delete} {send_log}',
                    'visibleButtons' => [
                        'update' => function ($model) {
                            return ($model->state == \common\models\c2\statics\InventoryDeliveryNoteState::INIT);
                        },
                        'init' => function ($model) {
                            return ($model->state == \common\models\c2\statics\InventoryDeliveryNoteState::CANCEL);
                        },
                        'cancel' => function ($model) {
                            return ($model->state == \common\models\c2\statics\InventoryDeliveryNoteState::INIT);
                        },
                        'send' => function ($model) {
                            return ($model->state == \common\models\c2\statics\InventoryDeliveryNoteState::INIT);
                        },
                        'send_log' => function ($model) {
                            return ($model->state == \common\models\c2\statics\InventoryDeliveryNoteState::SOLVED);
                        },
                        'processing' => function ($model) {
                            return ($model->state == \common\models\c2\statics\InventoryDeliveryNoteState::INIT);
                        },
                        'solved' => function ($model) {
                            return ($model->state == \common\models\c2\statics\InventoryDeliveryNoteState::INIT
                                || $model->state == \common\models\c2\statics\InventoryDeliveryNoteState::PROCESSING);
                        },
                        // 'print' => function ($model) {
                        //     return ($model->state != \common\models\c2\statics\InventoryDeliveryNoteState::CANCEL);
                        // },
                        'view' => function ($model) {
                            return ($model->state == \common\models\c2\statics\InventoryDeliveryNoteState::INIT);
                        },
                        // 'delete' => function ($model) {
                        //     return ($model->state == \common\models\c2\statics\InventoryDeliveryNoteState::CANCEL
                        //     || $model->state == \common\models\c2\statics\InventoryDeliveryNoteState::INIT);
                        // },
                    ],
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit', 'id' => $model->id], [
                                'title' => Yii::t('app', 'Info'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-default btn-xs',
                            ]);
                        },
                        'init' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'Init'), ['init', 'id' => $model->id], [
                                'title' => Yii::t('app.c2', 'Init'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-warning btn-xs init',
                            ]);
                        },
                        'cancel' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'Cancel'), ['cancel', 'id' => $model->id], [
                                'title' => Yii::t('app.c2', 'Cancel'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-danger btn-xs cancel',
                            ]);
                        },
                        'send' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'Product Send'), [
                                '/p3s/warehouse-note/delivery',
                                'id' => $model->id,
                                'f' => 'cl',
                            ], [
                                'title' => Yii::t('app.c2', 'Product Send'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-info btn-xs',
                            ]);
                        },
                        'send_log' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'Send Log'), [
                                '/p3s/warehouse-note/delivery/log',
                                'id' => $model->id,
                                'f' => 'cl',
                            ], [
                                'title' => Yii::t('app.c2', 'Send Log'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-info btn-xs',
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
                            return Html::a('<span class="glyphicon glyphicon-print"></span>', ['print', 'id' => $model->id], [
                                'title' => Yii::t('app.c2', 'Print'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-default btn-xs',
                                'target' => '_blank'
                            ]);
                        },
                        'view' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'View'), [
                                'view',
                                'note_id' => $model->id
                            ], [
                                'title' => Yii::t('app.c2', 'View'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-info btn-xs view',
                            ]);
                        },
                    ]
                ],

            ],
        ]); ?>

    </div>


<?php

\yii\bootstrap\Modal::begin([
    'id' => 'content-edit',
    'size' => 'modal-lg',
    'options' => [
        'tabindex' => false
    ],
]);

\yii\bootstrap\Modal::end();


$js = "";

$js .= "jQuery(document).off('click', 'a.view').on('click', 'a.view', function(e) {
            e.preventDefault();
            jQuery('#content-edit').modal('show').find('.modal-content').html('" . Yii::t('app.c2', 'Loading...') . "').load(jQuery(e.currentTarget).attr('href'));
        });";

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
                lib.confirm('" . Yii::t('app.c2', 'Are you sure cancel delivery note?') . "', function (result) {
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
                lib.confirm('" . Yii::t('app.c2', 'Are you sure commit delivery note?') . "', function (result) {
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
                lib.confirm('" . Yii::t('app.c2', 'Are you sure finish delivery note?') . "', function (result) {
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