<?php

use cza\base\widgets\ui\common\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\OrderItemConsumptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Order Item Consumptions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-item-consumption-index" style="margin-top: 20px">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,

        'pjax' => true,
        'hover' => true,
        'showPageSummary' => true,
        'panel' => ['type' => GridView::TYPE_INFO, 'heading' => Yii::t('app.c2', 'Material Stats')],
        'toolbar' => [
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
            //     'detailUrl' => Url::toRoute(['detail']),
            //     'value' => function ($model, $key, $index, $column) {
            //         return GridView::ROW_COLLAPSED;
            //     },
            // ],
            [
                'label' => Yii::t('app.c2', 'Order'),
                'value' => function ($model) {
                    return $model->orderItem->owner->code;
                }
            ],
            // 'sale_product_sum',
            // 'production_sum',
            // [
            //     'attribute' => 'sale_product_id',
            //     'group' => true,  // enable grouping
            //     'subGroupOf' => 1 // supplier column index is the parent group
            // ],
            // 'id',
            // 'order_id',
            // 'order_item_id',
            // 'need_product_id',
            'need_product_sku',
            'need_product_name',
            'need_product_label',
            'need_product_value',
            'need_number',
            // 'need_sum',
            [
                'attribute' => 'need_sum',
                'pageSummary' => true
            ],
            // 'sale_product_id',
            'memo',
            [
                'label' => Yii::t('app.c2', 'Stock'),
                'value' => function($model) {
                    return !is_null($model->needProduct) ? $model->needProduct->stock->number : 0;
                },
            ],
            [
                'class' => 'kartik\grid\FormulaColumn',
                'header' => Yii::t('app.c2', 'Diff Stock'),
                'value' => function ($model, $key, $index, $widget) {
                    $p = compact('model', 'key', 'index');
                    return $widget->col(8, $p) - $widget->col(6, $p);
                },
                'mergeHeader' => true,
                // 'pageSummary' => true
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
        ],
    ]);

    ?>

</div>
