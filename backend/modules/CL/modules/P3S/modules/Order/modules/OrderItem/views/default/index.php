<?php

use cza\base\widgets\ui\common\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\OrderItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Order Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="well order-item-index">

    <?php
    // echo $this->render('_search', ['model' => $searchModel]);
    echo Html::beginTag('div', ['class' => 'box-footer']);
    echo Html::a('<span class="glyphicon glyphicon-stats"></span> ' . Yii::t('app.c2', 'Stats'), [
        '/p3s/order/order-item-consumption', 'OrderItemConsumptionSearch[order_id]' => $order->id
    ], ['data-pjax' => '0', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Go Back'),]);
    echo Html::endTag('div');
    ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,

        'pjax' => true,
        'hover' => true,
        'showPageSummary' => true,
        'panel' => ['type' => GridView::TYPE_INFO, 'heading' => Yii::t('app.c2', 'Items')],
        'toolbar' => [
            [
                'content' =>
                // Html::a('<i class="glyphicon glyphicon-plus"></i>', ['edit'], [
                //     'class' => 'btn btn-success',
                //     'title' => Yii::t('app.c2', 'Add'),
                //     'data-pjax' => '0',
                // ]) . ' ' .
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
            // '{export}',
            // '{toggleData}',
        ],
        'exportConfig' => [],
        'columns' => [
            // ['class' => 'kartik\grid\CheckboxColumn'],
            // ['class' => 'kartik\grid\SerialColumn'],
            // [
            //     'class' => 'kartik\grid\ExpandRowColumn',
            //     'expandIcon' => '<span class="fa fa-plus-square-o"></span>',
            //     'collapseIcon' => '<span class="fa fa-minus-square-o"></span>',
            //     'detailUrl' => Url::toRoute([
            //         '/p3s/order/order-item-consumption/default/stats',
            //         'OrderItemConsumptionSearch[order_id]' => $order->id,
            //     ]),
            //     'value' => function ($model, $key, $index, $column) {
            //         return GridView::ROW_COLLAPSED;
            //     },
            // ],
            'id',
            // 'order_id',
            // 'label',
            // 'customer_id',
            // 'product_id',
            'product_name',
            'product_sku',
            // 'product_label',
            // 'product_value',
            // 'combination_id',
            'combination_name',
            // 'package_id',
            'package_name',
            // 'measure_id',
            'pieces',
            'send_pieces',
            [
                'class' => 'kartik\grid\FormulaColumn',
                'header' => Yii::t('app.c2', 'Diff Stock'),
                'value' => function ($model, $key, $index, $widget) {
                    $p = compact('model', 'key', 'index');
                    $value = $widget->col(5, $p) - $widget->col(6, $p);
                    return $value > 0 ? $value : 0;
                },
                'mergeHeader' => true,
                'pageSummary' => true
            ],
            'product_sum',
            'produced_number',
            [
                'class' => 'kartik\grid\FormulaColumn',
                'header' => Yii::t('app.c2', 'Diff Stock'),
                'value' => function ($model, $key, $index, $widget) {
                    $p = compact('model', 'key', 'index');
                    $value = $widget->col(6, $p) - $widget->col(7, $p);
                    return $value > 0 ? $value : 0;
                },
                'mergeHeader' => true,
                'pageSummary' => true
            ],
            // [
            //     // 'attribute' => 'order_id',
            //     'label' => Yii::t('app.c2', 'Stock'),
            //     // 'format' => ['decimal', 2],
            //     'value' => function ($model) {
            //         return $model->productCombination->stock;
            //     },
            //     // 'filter' => \common\models\c2\entity\Order::getHashMap('id', 'code')
            // ],
            // 'price',
            // 'subtotal',
            // 'memo',
            [
                'attribute' => 'memo',
                'format' => 'html',
            ],
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
            //     'buttons' => [
            //         'update' => function ($url, $model, $key) {
            //             return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit', 'id' => $model->id], [
            //                 'title' => Yii::t('app', 'Info'),
            //                 'data-pjax' => '0',
            //             ]);
            //         }
            //     ]
            // ],

        ],
    ]);

    echo Html::beginTag('div', ['class' => 'box-footer']);
    echo Html::a('<i class="fa fa-arrow-left"></i> ' . Yii::t('app.c2', 'Go Back'), '/p3s/order', ['data-pjax' => '0', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Go Back'),]);
    // echo Html::a('<i class="fa fa-window-close-o"></i> ' . Yii::t('app.c2', 'Close'), ['index'], ['data-pjax' => '0', 'data-dismiss' => 'modal', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Close'),]);
    echo Html::endTag('div');
    ?>

</div>
