<?php

use cza\base\widgets\ui\common\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\WarehouseNoteItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Warehouse Note Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="well warehouse-note-item-index">

    <div style="margin-bottom: 20px;">
        <?php
        if ($note) {
            echo $this->render('summary', ['model' => $note]);
        }
        ?>
    </div>


    <?php // echo $this->render('_search', ['model' => $searchModel]);
    echo Html::beginTag('div', ['class' => 'box-footer']);
    echo Html::a('<i class="fa fa-arrow-left"></i> ' . Yii::t('app.c2', 'Go Back'), ['/p3s/inventory/receipt-note'], ['data-pjax' => '0', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Go Back'),]);
    echo Html::endTag('div');
    ?>

    <?php

    $exportColumns = [
        [
            'value' => function ($model) {
                return $model->receiptNote->supplier->name;
            },
            'label' => Yii::t('app.c2', 'Supplier')
        ],
        [
            'value' => function ($model) {
                return $model->receiptNote->code;
            },
            'label' => Yii::t('app.c2', 'Code')
        ],
        'product_name',
        'product_sku',
        'measure.name',
        'number',
        'price',
        'subtotal',
        'memo',
        'created_at',
    ];

    $fullExportMenu = \backend\components\exports\CeExport::widget([
        'dataProvider' => $dataProvider,
        // 'groupByColIndex' => 2, // group by column's index (order id)
        'columns' => $exportColumns,
        'showColumnSelector' => false,
        'target' => \kartik\export\ExportMenu::TARGET_BLANK,
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
            \kartik\export\ExportMenu::FORMAT_TEXT => false,
            \kartik\export\ExportMenu::FORMAT_CSV => false,
            \kartik\export\ExportMenu::FORMAT_PDF => false,
        ],
        //                'filename' => utf8_encode(Yii::$app->formatter->asDate(time(), 'long') . "test"),
        'filename' => $note ? $note->supplier->name . '采购进仓记录' : '',
    ]);

    ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,

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
            'product_name',
            'product_sku',
            'measure.name',
            // 'product_label',
            // 'product_value',
            // 'combination_id',
            // 'combination_name',
            // 'package_id',
            // 'package_name',
            // 'pieces',
            'number',
            'price',
            'subtotal',
            'memo',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return \common\models\c2\statics\WarehouseNoteItemStatus::getLabel($model->status);
                }
            ],
            // 'status',
            // 'position',
            'created_at',
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
    ]); ?>

</div>
