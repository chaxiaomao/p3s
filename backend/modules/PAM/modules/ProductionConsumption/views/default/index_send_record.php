<?php

use cza\base\models\statics\OperationResult;
use cza\base\widgets\ui\common\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\ProductionConsumptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Warehouse Commit Log');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="well production-consumption-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        // 'id' => $model->getPrefixName('grid'),
        'pjax' => true,
        'hover' => true,
        'showPageSummary' => true,
        'panel' => ['type' => GridView::TYPE_PRIMARY, 'heading' => Yii::t('app.c2', 'Items')],
        'toolbar' => [
            [
                'content' =>

                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', Url::current(), [
                        'id' => 'consumption-refresh',
                        'class' => 'btn btn-default',
                        'title' => Yii::t('app.c2', 'Reset Grid')
                    ]),
            ],
            // '{export}',
            '{toggleData}',
        ],
        'exportConfig' => [],
        'columns' => [
            // ['class' => 'kartik\grid\CheckboxColumn'],
            // ['class' => 'kartik\grid\SerialColumn'],
            // [
            //     'class' => 'kartik\grid\ExpandRowColumn',
            //     'expandIcon' => '<span class="fa fa-plus-square-o"></span>',
            //     'collapseIcon' => '<span class="fa fa-minus-square-o"></span>',
            //     'detailUrl' => Url::toRoute(['detail']),
            //     'value' => function ($model, $key, $index, $column) {
            //         return GridView::ROW_COLLAPSED;
            //     },
            // ],
            'id',
            // 'schedule_id',
            // 'schedule_item_id',
            // 'need_product_id',
            'need_product_sku',
            'need_product_name',
            'need_product_label',
            'need_product_value',
            // 'need_number',
            [
                'label' => Yii::t('app.c2', 'Measure'),
                'value' => function ($model) {
                    return '';
                    // return !is_null($model->product->measure) ? $model->product->measure->name : '';
                }
            ],
            'need_sum',
            'send_sum',
            // [
            //     'attribute' => 'send_sum',
            //     'class' => '\kartik\grid\EditableColumn',
            //     'editableOptions' => [
            //         'inputType' => \kartik\editable\Editable::INPUT_TEXT,
            //         'formOptions' => ['action' => Url::toRoute('editColumn')],
            //     ],
            // ],
            'memo',
            [
                'attribute' => 'is_customer',
                'label' => '备注',
                'format' => 'html',
                'value' => function ($model) {
                    return (isset($model['is_customer']) && $model['is_customer']) ? "<span style='color: red'>自定义送料</spam>" : '';
                    // return !is_null($model->product->measure) ? $model->product->measure->name : '';
                }
            ],
            // 'state',
            // 'status',
            // 'position',
            // 'created_at',
            // 'updated_at',
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
            // [
            //     'class' => '\kartik\grid\ActionColumn',
            //     'template' => '{send} {back}',
            //     'buttons' => [
            //         'send' => function ($url, $model, $key) {
            //             return Html::a(Yii::t('app.c2', 'Send Mixture'), ['send-mixture', 'id' => $model->id], [
            //                 'title' => Yii::t('app', 'Info'),
            //                 'data-pjax' => '0',
            //                 'class' => 'btn btn-success btn-xs send',
            //             ]);
            //         },
            //         'back' => function ($url, $model, $key) {
            //             return Html::a(Yii::t('app.c2', 'Back Mixture'), ['back-mixture', 'id' => $model->id], [
            //                 'title' => Yii::t('app', 'Info'),
            //                 'data-pjax' => '0',
            //                 'class' => 'btn btn-warning btn-xs back',
            //             ]);
            //         },
            //     ]
            // ],

        ],
    ]);

    echo Html::beginTag('div', ['class' => 'box-footer']);
    echo Html::a('<i class="fa fa-arrow-left"></i> ' . Yii::t('app.c2', 'Go Back'), '/pam/production-schedule', ['data-pjax' => '0', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Go Back'),]);
    echo Html::endTag('div');

    ?>

</div>


<?php
// \yii\bootstrap\Modal::begin([
//     'id' => 'edit',
//     // 'size' => 'modal-sm',
//     // 'options' => [
//     //     'tabindex' => false
//     // ],
// ]);
// $js = "";
// $js .= "jQuery(document).off('click', 'a.send').on('click', 'a.send', function(e) {
//             e.preventDefault();
//             jQuery('#edit').modal('show').find('.modal-content').html('" . Yii::t('app.c2', 'Loading...') . "').load(jQuery(e.currentTarget).attr('href'));
//         });";
//
// $js .= "jQuery(document).off('click', 'a.back').on('click', 'a.back', function(e) {
//             e.preventDefault();
//             jQuery('#edit').modal('show').find('.modal-content').html('" . Yii::t('app.c2', 'Loading...') . "').load(jQuery(e.currentTarget).attr('href'));
//         });";
//
// $js .= "jQuery(document).off('click', 'a.all-send').on('click', 'a.all-send', function(e) {
//                 e.preventDefault();
//                 var lib = window['krajeeDialog'];
//                 var url = jQuery(e.currentTarget).attr('href');
//                 lib.confirm('" . Yii::t('app.c2', 'Are you sure?') . "', function (result) {
//                     if (!result) {
//                         return;
//                     }
//                     jQuery.ajax({
//                             url: url,
//                             success: function(data) {
//                                 var lifetime = 6500;
//                                 if(data._meta.result == '" . cza\base\models\statics\OperationResult::SUCCESS . "'){
//                                     jQuery('#{$model->getPrefixName('grid')}').trigger('" . OperationEvent::REFRESH . "');
//                                 }
//                                 else{
//                                   lifetime = 16500;
//                                 }
//                                 jQuery.msgGrowl ({
//                                         type: data._meta.type,
//                                         title: '" . Yii::t('cza', 'Tips') . "',
//                                         text: data._meta.message,
//                                         position: 'top-center',
//                                         lifetime: lifetime,
//                                 });
//                             },
//                             error :function(data){alert(data._meta.message);}
//                     });
//                 });
//             });";
//
// $this->registerJs($js);


?>
