<?php

use cza\base\widgets\ui\common\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel \backend\models\c2\entity\cl\ProductionScheduleItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '生产预算';
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
                'product_sku',
                'product_name',
                'product_label',
                'product_value',
                // 'total_production',
                [
                    'attribute' => 'total_production',
                    'label' => '生产总量',
                    'value' => function ($model) {
                        // return $model['total_production'] . $model['product']['measure']['name'];
                        return $model['total_production'];
                    }
                ],
                [
                    'attribute' => 'memo',
                    'format' => 'html',
                ],
                [
                    'attribute' => 'occurrence_date',
                    'label' => '下单时间',
                    'value' => function ($model) {
                        return $model['occurrence_date'] ? date('Y-m-d', strtotime($model['occurrence_date'])) : '';
                    }
                ],
                [
                    'attribute' => 'estimated_ship_date',
                    'label' => '预计出货时间',
                    'value' => function ($model) {
                        return $model['estimated_ship_date'] ? date('Y-m-d', strtotime($model['estimated_ship_date'])) : '';
                    }
                ],
                // [
                //     'attribute' => 'actual_ship_date',
                //     'label' => '实际时间',
                //     'value' => function ($model) {
                //         return $model['actual_ship_date'] ? date('Y-m-d', strtotime($model['actual_ship_date'])) : '';
                //     }
                // ],
                // [
                //     // 'attribute' => 'occurrence_date',
                //     'label' => '下单时间',
                //     'format' => 'html',
                //      'value' => function ($model) {
                //         $html = '';
                //         if ($model['occurrence_date']) {
                //             $date = date('Y-m-d', strtotime($model['occurrence_date']));
                //             $html .= "<p>1{$date}</p>";
                //         }
                //         if ($model['estimated_ship_date']) {
                //             $date = date('Y-m-d', strtotime($model['estimated_ship_date']));
                //             $html .= "<p>2{$date}</p>";
                //         }
                //         if ($model['actual_ship_date']) {
                //             $date = date('Y-m-d', strtotime($model['actual_ship_date']));
                //             $html .= "<p>3{$date}</p>";
                //         }
                //         return $html;
                //          // return $model['total_production'] . $model['product']['measure']['name'];
                //          // return $model->occurrence_date ? date('Y-m-d', strtotime($model->occurrence_date)) : '';
                //      }
                // ],
                // 'created_at',
                [
                    'class' => \common\widgets\grid\ActionColumn::className(),
                    // 'width' => '200px',
                    'template' => '',
                    // 'template' => '{send_log}',
                    'visibleButtons' => [
                        'send_log' => function ($model) {
                            return true;
                        },
                    ],
                    'buttons' => [
                        'send_log' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'Send Log'), [
                                '/p3s/warehouse-note/delivery/log',
                                'id' => $model->id
                            ], [
                                'title' => Yii::t('app.c2', 'Send Log'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-info btn-xs',
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