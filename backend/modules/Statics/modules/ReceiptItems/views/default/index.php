<?php

use cza\base\widgets\ui\common\grid\GridView;
use kartik\export\ExportMenu;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\InventoryReceiptNoteItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Inventory Receipt Note Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="well inventory-receipt-note-item-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php

    $exportColumns = [
        'code',
        [
            'attribute' => 'supplier_id',
            'value' => function ($model) {
                return !is_null($model->supplier) ? $model->supplier->name : '';
            },
            'filter' => \common\models\c2\entity\Supplier::getHashMap('id', 'name')
        ],
        'product_sku',
        'product_name',
        'product_label',
        'product_value',
        [
            'attribute' => 'price',
            'format' => ['decimal', 4],
            'pageSummary' => true
        ],
        // 'measure_id',
        'number',
        [
            'attribute' => 'subtotal',
            'format' => ['decimal', 4],
            'pageSummary' => true,
            'value' => function ($model) {
                return $model->number * $model->price;
            }
        ],
        'memo',
        // 'status',
        // 'position',
        'created_at',
    ];

    // $query = \common\models\c2\entity\ProductStock::find();
    // $dataProviderAll = new ActiveDataProvider([
    //     'query' => $query,
    //     'pagination' => [
    //         'pageSize' => 2000,
    //     ],
    // ]);

    $fullExportMenu = \backend\components\exports\CeExport::widget([
        'dataProvider' => $dataProvider,
        'groupByColIndex' => 0, // group by column's index (order id)
        'columns' => $exportColumns,
        'showColumnSelector' => false,
        'target' => ExportMenu::TARGET_BLANK,
        'fontAwesome' => true,
        'pjaxContainerId' => 'kv-pjax-container',
        'dropdownOptions' => [
            'label' => Yii::t('app.c2', 'Export Data'),
            'class' => 'btn btn-default',
            'itemsBefore' => [
                '<li class="dropdown-header">' . Yii::t('app.c2', 'Export Current Data') . '</li>',
            ],
        ],
        'exportConfig' => [
            ExportMenu::FORMAT_TEXT => false,
            ExportMenu::FORMAT_CSV => false,
            ExportMenu::FORMAT_PDF => false,
        ],
        //                'filename' => utf8_encode(Yii::$app->formatter->asDate(time(), 'long') . "test"),
        'filename' => "Receipt Items_" . date("Y-m-d", time()),
    ]);

    ?>

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
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', Url::current(), [
                        'class' => 'btn btn-default',
                        'title' => Yii::t('app.c2', 'Reset Grid')
                    ]),
            ],
            $fullExportMenu,
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
            // 'id',
            // 'note_id',
            // 'product_id',
            'code',
            [
                'attribute' => 'supplier_id',
                'value' => function ($model) {
                    return !is_null($model->supplier) ? $model->supplier->name : '';
                },
                'filter' => \common\models\c2\entity\Supplier::getHashMap('id', 'name')
            ],
            // 'supplier_id',
            'product_sku',
            'product_name',
            'product_label',
            'product_value',
            // 'measure_id',
            'number',
            // 'price',
            // 'subtotal',
            [
                'attribute' => 'price',
                // 'pageSummary' => true
            ],
            [
                'attribute' => 'subtotal',
                'format' => ['decimal', 4],
                'pageSummary' => true,
                'value' => function ($model) {
                    return $model->number * $model->price;
                }
            ],
            'memo',
            // 'status',
            // 'position',
            'created_at',
            // 'updated_at',
            [
                'attribute' => 'status',
                // 'class' => '\kartik\grid\EditableColumn',
                // 'editableOptions' => [
                //     'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                //     'formOptions' => ['action' => Url::toRoute('editColumn')],
                //     'data' => EntityModelStatus::getHashMap('id', 'label'),
                //     'displayValueConfig' => EntityModelStatus::getHashMap('id', 'label'),
                // ],
                'filter' => \common\models\c2\statics\WarehouseNoteItemStatus::getHashMap('id', 'label'),
                'value' => function ($model) {
                    return \common\models\c2\statics\WarehouseNoteItemStatus::getLabel($model->status);
                }
            ],
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
