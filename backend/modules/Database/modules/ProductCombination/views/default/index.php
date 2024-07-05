<?php

use cza\base\widgets\ui\common\grid\GridView;
use kartik\export\ExportMenu;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\ProductCombinationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Product Combinations');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="well product-combination-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php

        $exportColumns = [
            [
                // 'attribute' => 'label',
                'label' => Yii::t('app.c2', 'Product Number'),
                'value' => function ($model) {
                    return $model->product->sku;
                },
            ],
            [
                // 'attribute' => 'label',
                'label' => Yii::t('app.c2', 'Product Name'),
                'value' => function ($model) {
                    return $model->product->name . '(' . $model->name . ')';
                },
            ],
            [
                'attribute' => 'label',
                'label' => Yii::t('app.c2', 'Series'),
                'format' => 'html',
                'value' => function ($model) {
                    return is_null($model->label) ? '' : $model->label;
                },
            ],
            'stock',
            // 'summary',
            [
                'attribute' => 'memo',
                'format' => 'html',
                'value' => function ($model) {
                    return is_null($model->memo) ? '' : $model->memo;
                },
            ],
        ];

        $query = \common\models\c2\entity\ProductCombination::find();
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
            'filename' => "Combination_" . date("Y-m-d", time()),
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
                // 'product_id',
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
                [
                    'attribute' => 'sku',
                    // 'label' => 'sku',
                    'value' => function ($model) {
                        return $model->product->sku;
                    },
                ],
                [
                    'attribute' => 'product_name',
                    'value' => function ($model) {
                        return $model->product->name . '(' . $model->name . ')';
                    },
                ],
                // 'name',
                // 'label',
                // 'stock',
                [
                    'attribute' => 'stock',
                    // 'class' => '\kartik\grid\EditableColumn',
                    // 'editableOptions' => [
                    //     'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    //     'formOptions' => ['action' => Url::toRoute('editColumn')],
                    // ],
                ],
                // [
                //     'format' => 'html',
                //     'label' => Yii::t('app,c2', 'Album'),
                //     'value' => function ($model) {
                //         $attachment = $model->attachmentImages;
                //         if (!is_null($attachment) && isset($attachment[0])) {
                //             return Html::img($attachment[0]->getIconUrl(), ['width' => '100%']);
                //         }
                //         return '';
                //     }
                // ],
                // 'memo:ntext',
                // 'status',
                // 'position',
                'created_at',
                'updated_at',
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
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{update} {log}',
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit', 'id' => $model->id], [
                                'title' => Yii::t('app', 'Info'),
                                'data-pjax' => '0',
                                'class' => 'update'
                            ]);
                        },
                        'log' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-log-out"></span>', [
                                '/p3s/warehouse-note-item/',
                                'WarehouseNoteItemSearch[combination_id]' => $model->id
                            ], [
                                'title' => Yii::t('app', 'Info'),
                                'data-pjax' => '0',
                            ]);
                        },
                    ]
                ],

            ],
        ]); ?>

    </div>
<?php
// \yii\bootstrap\Modal::begin([
//     'id' => 'content-edit',
//     'size' => 'modal-lg'
// ]);
//
// \yii\bootstrap\Modal::end();
//
// $js = "";
//
// $js .= "jQuery(document).off('click', 'a.update').on('click', 'a.update', function(e) {
//             e.preventDefault();
//             jQuery('#content-edit').modal('show').find('.modal-content').html('" . Yii::t('app.c2', 'Loading...') . "').load(jQuery(e.currentTarget).attr('href'));
//         });";
//
// $this->registerJs($js);

?>

<?php
\yii\bootstrap\Modal::begin([
    'id' => 'content-edit',
    'size' => 'modal-lg'
]);

\yii\bootstrap\Modal::end();

$js = "";

$js .= "jQuery(document).off('click', 'a.view-albums').on('click', 'a.view-albums', function(e) {
            e.preventDefault();
            jQuery('#content-edit').modal('show').find('.modal-content').html('" . Yii::t('app.c2', 'Loading...') . "').load(jQuery(e.currentTarget).attr('href'));
        });";

$this->registerJs($js);

?>
