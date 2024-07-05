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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,

        'pjax' => true,
        'hover' => true,
        'showPageSummary' => true,
        'panel' => ['type' => GridView::TYPE_PRIMARY, 'heading' => Yii::t('app.c2', 'Items')],
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

                    Html::a('<i class="glyphicon glyphicon-align-justify">' . Yii::t('app.c2', 'All Order Items') . '</i>', ['table-index'], [
                        'class' => 'btn btn-danger',
                        'title' => Yii::t('app.c2', 'All'),
                    ]) . ' ' .
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
            // 'order_id',
            [
                'attribute' => 'order_id',
                'label' => Yii::t('app.c2', 'Code'),
                'value' => function ($model) {
                    return $model->order->code;
                },
                'filter' => \common\models\c2\entity\Order::getHashMap('id', 'code', [
                    'state' => \common\models\c2\statics\OrderState::PROCESSING
                ])
            ],
            // 'label',
            // 'customer_id',
            // 'product_id',
            'product_sku',
            'product_name',
            // 'product_label',
            // 'product_value',
            // 'combination_id',
            'combination_name',
            // 'package_id',
            'package_name',
            // 'measure_id',
            [
                'attribute' => 'measure_id',
                'value' => function ($model) {
                    return !is_null($model->product->measure) ? $model->product->measure->name : '';
                },
                // 'filter' => \common\models\c2\entity\Order::getHashMap('id', 'code')
            ],
            'pieces',
            // 'product_sum',
            [
                'attribute' => 'product_sum',
                // 'format' => ['decimal', 2],
                'pageSummary' => true
            ],
            // 'produced_number',
            // [
            //     'label' => Yii::t('app.c2', 'Stock'),
            //     'value' => function ($model) {
            //         return $model->productCombination->stock;
            //     },
            // ],
            [
                'attribute' => 'produced_number',
                // 'format' => ['decimal', 2],
                'pageSummary' => true
            ],
            // 'price',
            // 'send_pieces',
            // [
            //     'attribute' => 'send_pieces',
            //     // 'format' => ['decimal', 2],
            //     'pageSummary' => true
            // ],
            // [
            //     'label' => Yii::t('app.c2', 'Send Number'),
            //     'value' => function ($model) {
            //         return $model->send_pieces * $model->productPackage->product_capacity;
            //     },
            // ],
            'created_at',
            [
                'class' => 'kartik\grid\FormulaColumn',
                'header' => Yii::t('app.c2', 'Diff Stock'),
                'value' => function ($model, $key, $index, $widget) {
                    $p = compact('model', 'key', 'index');
                    return $widget->col(9, $p) - $widget->col(10, $p);
                },
                'mergeHeader' => true,
                'pageSummary' => true
            ],
            // 'subtotal',
            // [
            //     'attribute' => 'subtotal',
            //     // 'format' => ['decimal', 2],
            //     'pageSummary' => true
            // ],
            'memo',
            // 'status',
            // 'position',
            // 'updated_at',
            // [
            //     'attribute' => 'status',
            //     // 'class' => '\kartik\grid\EditableColumn',
            //     // 'editableOptions' => [
            //     //     'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
            //     //     'formOptions' => ['action' => Url::toRoute('editColumn')],
            //     //     'data' => EntityModelStatus::getHashMap('id', 'label'),
            //     //     'displayValueConfig' => EntityModelStatus::getHashMap('id', 'label'),
            //     // ],
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
    ]); ?>

</div>
