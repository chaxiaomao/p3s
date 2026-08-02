<?php

use cza\base\widgets\ui\common\grid\GridView;
use kartik\export\ExportMenu;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\InventoryDeliveryNoteItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Inventory Delivery Note Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="well inventory-delivery-note-item-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php

    $exportColumns = [
        [
            'attribute' => 'customer_id',
            'value' => function ($model) {
                return $model->customer->username;
            },
            'filter' => \common\models\c2\entity\FeUser::getHashMap('id', 'username', [
                'status' => EntityModelStatus::STATUS_ACTIVE
            ])
        ],
        // 'product_id',
        'product_sku',
        'product_name',
        // 'package_id',
        'combination_name',
        'package_name',
        // 'combination_id',
        // 'measure_id',
        // 'pieces',
        [
            'attribute' => 'pieces',
            'format' => ['decimal', 2],
            // 'pageSummary' => true
        ],
        // 'product_sum',
        [
            'attribute' => 'product_sum',
            // 'pageSummary' => true
        ],
        // 'volume',
        // 'weight',
        // 'price',
        [
            'attribute' => 'price',
            'format' => ['decimal', 2],
        ],
        [
            'attribute' => 'subtotal',
            'format' => ['decimal', 2],
            'pageSummary' => true
        ],
        // 'subtotal',
        'memo',
        // 'status',
        // 'position',
        'created_at',
    ];

    $fullExportMenu = ExportMenu::widget([
        'dataProvider' => $dataProvider,
        // 'groupByColIndex' => 2, // group by column's index (order id)
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
            // ExportMenu::FORMAT_TEXT => false,
            // ExportMenu::FORMAT_CSV => false,
            // ExportMenu::FORMAT_PDF => false,
        ],
        //                'filename' => utf8_encode(Yii::$app->formatter->asDate(time(), 'long') . "test"),
        'filename' => "Delivery Items_" . time(),
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
            // 'export' => false,
            '{toggleData}',
        ],
        'exportConfig' => [],
        'columns' => [
            ['class' => 'kartik\grid\CheckboxColumn'],
            ['class' => 'kartik\grid\SerialColumn'],
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
            // 'customer_id',
            // [
            //     'attribute' => 'customer_id',
            //     'value' => function ($model) {
            //         return $model->customer->username;
            //     },
            //     'filter' => \common\models\c2\entity\FeUser::getHashMap('id', 'username', [
            //         'status' => EntityModelStatus::STATUS_ACTIVE
            //     ])
            // ],

            [
                'attribute' => 'customer_id',
                'width' => '160px',
                'value' => function ($model) {
                    return !empty($model->customer) ? $model->customer->username : '';
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \common\models\c2\entity\FeUser::getHashMap('id', 'username', [
                    'status' => EntityModelStatus::STATUS_ACTIVE
                ]),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => ''],
                'format' => 'raw'
            ],

            // [
            //     'filter' => \kartik\widgets\Select2::widget([
            //         'model' => $searchModel,
            //         'attribute' => 'customer_id',
            //         'data' => \common\models\c2\entity\FeUser::getHashMap('id', 'username', [
            //             'status' => EntityModelStatus::STATUS_ACTIVE
            //         ]),
            //         'options' => [
            //             'placeholder' => \Yii::t('app.c2', 'Select role'),
            //         ],
            //         'pluginOptions' => [
            //             'allowClear' => true,
            //         ],
            //     ]),
            //     'format' => 'html',
            //     'hAlign' => 'center',
            //     // 'width' => '9%',
            //     'value' => function ($model) {
            //         return $model->customer->username;
            //     },
            // ],

            // 'product_id',
            'product_sku',
            'product_name',
            // 'package_id',
            'combination_name',
            'package_name',
            // 'combination_id',
            // 'measure_id',
            // 'pieces',
            [
                'attribute' => 'pieces',
                'pageSummary' => true
            ],
            // 'product_sum',
            [
                'attribute' => 'product_sum',
                'pageSummary' => true
            ],
            // 'volume',
            // 'weight',
            'price',
            [
                'attribute' => 'subtotal',
                'format' => ['decimal', 2],
                'pageSummary' => true
            ],
            // 'subtotal',
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
                'filter' => EntityModelStatus::getHashMap('id', 'label'),
                'value' => function ($model) {
                    return $model->getStatusLabel();
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
