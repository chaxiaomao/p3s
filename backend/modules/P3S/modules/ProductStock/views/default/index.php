<?php

use cza\base\widgets\ui\common\grid\GridView;
use kartik\export\ExportMenu;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\ProductStockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Product Stocks');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="well product-stock-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php

    $exportColumns = [
        [
            'attribute' => 'sku',
            'label' => Yii::t('app.c2', 'Sku'),
            'value' => function ($model) {
                return $model->product->sku;
            },
        ],
        [
            'attribute' => 'product_name',
            'label' => Yii::t('app.c2', 'Product'),
            'value' => function ($model) {
                return $model->product->name;
            },
        ],
        [
            'label' => Yii::t('app.c2', 'Measure'),
            'value' => function ($model) {
                return !is_null($model->product->measure) ? $model->product->measure->name : '';
            },
        ],
        [
            'label' => Yii::t('app.c2', 'Price'),
            'value' => function ($model) {
                return $model->number * $model->product->low_price;
            },
        ],
        'number',
    ];

    $query = \common\models\c2\entity\ProductStock::find();
    $dataProviderAll = new ActiveDataProvider([
        'query' => $query,
        'pagination' => [
            'pageSize' => 2000,
        ],
    ]);

    $fullExportMenu = \backend\components\exports\CeExport::widget([
        'dataProvider' => $dataProviderAll,
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
        'filename' => "Sales Order_" . date("Y-m-d", time()),
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
            // 'warehouse_id',
            [
                'attribute' => 'warehouse_id',
                'value' => function ($model) {
                    return !is_null($model->warehouse) ? $model->warehouse->name : '';
                },
                'filter' => \common\models\c2\entity\Warehouse::getHashMap('id', 'name', [
                    'status' => EntityModelStatus::STATUS_ACTIVE
                ])
            ],
            // 'product_id',
            [
                'attribute' => 'product_name',
                'label' => Yii::t('app.c2', 'Product'),
                'value' => function ($model) {
                    $product = $model->product;
                    return $product->sku . '(' . $product->name . ')' . $product->value;
                },
            ],
            // [
            //     'label' => Yii::t('app.c2', 'Sku'),
            //     'value' => function ($model) {
            //         return $model->product->sku;
            //     },
            // ],
            // [
            //     'label' => Yii::t('app.c2', 'Label'),
            //     'value' => function ($model) {
            //         return $model->product->label;
            //     },
            // ],
            // [
            //     'label' => Yii::t('app.c2', 'Value'),
            //     'value' => function ($model) {
            //         return $model->product->value;
            //     },
            // ],
            [
                'label' => Yii::t('app.c2', 'Measure'),
                'value' => function ($model) {
                    return !is_null($model->product->measure) ? $model->product->measure->name : '';
                },
            ],
            // 'number',
            [
                'attribute' => 'number',
                'class' => '\kartik\grid\EditableColumn',
                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'formOptions' => ['action' => Url::toRoute('editColumn')],
                ],
            ],
            // 'state',
            // 'status',
            // 'position',
            'created_at',
            'updated_at',
            [
                'attribute' => 'status',
                'class' => '\kartik\grid\EditableColumn',
                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    'formOptions' => ['action' => Url::toRoute('editColumn')],
                    'data' => EntityModelStatus::getHashMap('id', 'label'),
                    'displayValueConfig' => EntityModelStatus::getHashMap('id', 'label'),
                ],
                'filter' => EntityModelStatus::getHashMap('id', 'label'),
                'value' => function ($model) {
                    return $model->getStatusLabel();
                }
            ],
            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit', 'id' => $model->id], [
                            'title' => Yii::t('app', 'Info'),
                            'data-pjax' => '0',
                        ]);
                    }
                ]
            ],

        ],
    ]); ?>

</div>
