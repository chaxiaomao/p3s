<?php

use cza\base\widgets\ui\common\grid\GridView;
use kartik\export\ExportMenu;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="well product-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php

        $exportColumns = [
            'sku',
            'name',
            // 'label',
            [
                'attribute' => 'label',
                'format' => 'html',
                'value' => function ($model) {
                    return is_null($model->label) ? '' : $model->label;
                },
            ],
            [
                'label' => Yii::t('app.c2', 'Measure'),
                'value' => function ($model) {
                    return !is_null($model->measure) ? $model->measure->name : '';
                },
            ],
            'low_price',
            'stock',
            // 'summary',
            [
                'attribute' => 'summary',
                'format' => 'html',
                'value' => function ($model) {
                    return is_null($model->summary) ? '' : $model->summary;
                },
            ],
        ];

        $query = \common\models\c2\entity\Product::find()
            ->andWhere(['type' => \common\models\c2\statics\ProductType::TYPE_PRODUCT]);
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
            'filename' => "Product_" . date("Y-m-d", time()),
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
                    'content' => yii\bootstrap\ButtonDropdown::widget([
                            'label' => "<i class='glyphicon glyphicon-plus'></i> " . Yii::t("app.c2", "Create"),
                            'encodeLabel' => false,
                            'options' => [
                                'class' => 'btn btn-success',
                            ],
                            'dropdown' => [
                                'items' => [
                                    ['label' => \common\models\c2\statics\ProductType::getMaterial(), 'url' => ['/database/product/material/edit'], 'linkOptions' => ['data-pjax' => '0', 'class' => 'material']],
                                    ['label' => \common\models\c2\statics\ProductType::getProduct(), 'url' => ['edit'], 'linkOptions' => ['data-pjax' => '0']],
                                ],
                            ],
                        ]) .
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

                [
                    'class' => \common\widgets\grid\ActionColumn::className(),
                    'template' => '{view}',
                    'header' => Yii::t('app.c2', 'Albums'),
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'View Albums'), [
                                'view-albums', 'id' => $model->id,
                            ], [
                                'data-pjax' => '0',
                                'class' => 'view-albums',
                            ]);
                        },
                    ]
                ],
                // [
                //     // 'attribute' => 'type',
                //     'label' => Yii::t('app.c2', 'Type'),
                //     'value' => function ($model) {
                //         return \common\models\c2\statics\ProductType::getLabel($model->type);
                //     },
                //     // 'filter' => \common\models\c2\statics\ProductType::getHashMap('id', 'label')
                // ],
                // 'seo_code',
                'sku',
                'name',
                // 'label',
                // 'value',
                // 'low_price',
                [
                    'attribute' => 'low_price',
                    'class' => '\kartik\grid\EditableColumn',
                    'editableOptions' => [
                        'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                        'formOptions' => ['action' => Url::toRoute('editColumn')],
                    ],
                ],
                [
                    'attribute' => 'stock',
                    // 'class' => '\kartik\grid\EditableColumn',
                    // 'editableOptions' => [
                    //     'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    //     'formOptions' => ['action' => Url::toRoute('editColumn')],
                    // ],
                ],
                [
                    'label' => Yii::t('app.c2', 'Measure'),
                    'value' => function ($model) {
                        return !is_null($model->measure) ? $model->measure->name : '';
                    },
                ],
                // 'sales_price',
                // 'cost_price',
                // 'market_price',
                // 'supplier_id',
                // 'currency_id',
                // 'measure_id',
                // 'summary:ntext',
                // 'description:ntext',
                // 'sold_count',
                // 'is_released',
                // 'released_at',
                // 'created_by',
                [
                    'attribute' => 'created_by',
                    'value' => function ($model) {
                        return !is_null($model->creator) ? $model->creator->username : '';
                    },
                    // 'filter' => \common\models\c2\statics\ProductType::getHashMap('id', 'label')
                ],
                [
                    'attribute' => 'updated_by',
                    'value' => function ($model) {
                        return !is_null($model->updator) ? $model->updator->username : '';
                    },
                ],
                // 'updated_by',
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
                    'class' => \common\widgets\grid\ActionColumn::className(),
                    'template' => '{view} {update} {delete}',
                    'visibleButtons' => [
                        // 'update-material' => function ($model) {
                        //     return ($model->type == \common\models\c2\statics\ProductType::TYPE_MATERIAL);
                        // },
                        'update' => function ($model) {
                            return ($model->type == \common\models\c2\statics\ProductType::TYPE_PRODUCT);
                        }
                    ],
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit', 'id' => $model->id], [
                                'title' => Yii::t('app', 'Info'),
                                'data-pjax' => '0',
                            ]);
                        },
                        'log' => function ($url, $model, $key) {
                            return Html::a('库存记录', [
                                '/p3s/warehouse-note-item/default/log',
                                'WarehouseNoteItemSearch[product_id]' => $model->id
                            ], [
                                'title' => Yii::t('app', '仓库记录'),
                                'data-pjax' => '0',
                            ]);
                        },
                        // 'update-material' => function ($url, $model, $key) {
                        //     return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/database/product/material/edit', 'id' => $model->id], [
                        //         'title' => Yii::t('app', 'Info'),
                        //         'data-pjax' => '0',
                        //         'class' => 'material',
                        //     ]);
                        // },
                    ]
                ],

            ],
        ]); ?>

    </div>


<?php
\yii\bootstrap\Modal::begin([
    'id' => 'content-edit',
    'size' => 'modal-lg'
]);

\yii\bootstrap\Modal::end();

$js = "";

$js .= "jQuery(document).off('click', 'a.material').on('click', 'a.material', function(e) {
            e.preventDefault();
            jQuery('#content-edit').modal('show').find('.modal-content').html('" . Yii::t('app.c2', 'Loading...') . "').load(jQuery(e.currentTarget).attr('href'));
        });";

$js .= "jQuery(document).off('click', 'a.view-albums').on('click', 'a.view-albums', function(e) {
            e.preventDefault();
            jQuery('#content-edit').modal('show').find('.modal-content').html('" . Yii::t('app.c2', 'Loading...') . "').load(jQuery(e.currentTarget).attr('href'));
        });";

$this->registerJs($js);

?>