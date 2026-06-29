<?php

use cza\base\widgets\ui\common\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\ProductionCombinationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = Yii::t('app.c2', 'Product Combinations');
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-combination-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        // 'id' => 'combination-grid',
        'pjax' => true,
        'hover' => true,
        // 'showPageSummary' => true,
        'panel' => ['type' => GridView::TYPE_SUCCESS, 'heading' => Yii::t('app.c2', 'Items')],
        'toolbar' => [
            [
                'content' =>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/database/product/combination/default/edit', 'product_id' => $productModel->id], [
                        'class' => 'btn btn-success combination',
                        'title' => Yii::t('app.c2', 'Add'),
                        'data-pjax' => '0',
                    ]) . ' ' .
                    // Html::button('<i class="glyphicon glyphicon-remove"></i>', [
                    //     'class' => 'btn btn-danger',
                    //     'title' => Yii::t('app.c2', 'Delete Selected Items'),
                    //     'onClick' => "jQuery(this).trigger('" . OperationEvent::DELETE_BY_IDS . "', {url:'" . Url::toRoute('/database/product/combination/default/multiple-delete') . "'});",
                    // ]) . ' ' .
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', Url::current(), [
                        'class' => 'btn btn-default',
                        'id' => 'combination-refresh',
                        'title' => Yii::t('app.c2', 'Reset Grid')
                    ]),
            ],
            // '{export}',
            // '{toggleData}',
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
            'id',
            // 'product_id',
            'name',
            'label',
            'stock',
            'memo:ntext',
            // 'status',
            // 'position',
            // 'created_at',
            // 'updated_at',
            [
                'attribute' => 'status',
                // 'class' => '\kartik\grid\EditableColumn',
                // 'editableOptions' => [
                //     'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                //     'formOptions' => ['action' => Url::toRoute('/database/product/combination/default/editColumn')],
                //     'data' => EntityModelStatus::getHashMap('id', 'label'),
                //     'displayValueConfig' => EntityModelStatus::getHashMap('id', 'label'),
                // ],
                // 'filter' => EntityModelStatus::getHashMap('id', 'label'),
                'value' => function ($model) {
                    return $model->getStatusLabel();
                }
            ],
            [
                'class' => \common\widgets\grid\ActionColumn::className(),
                'template' => '{update} {delete} {log}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', [
                            '/database/product/combination/default/edit',
                            'id' => $model->id,
                            'product_id' => $model->product_id
                        ], [
                            'title' => Yii::t('app', 'Info'),
                            'data-pjax' => '0',
                            'class' => 'combination',
                        ]);
                    },
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', [
                            '/database/product/combination/default/delete',
                            'id' => $model->id,
                        ], [
                            'title' => Yii::t('app', 'Info'),
                            'data-pjax' => '0',
                            'class' => 'delete-combination',
                        ]);
                    },
                    'log' => function ($url, $model, $key) {
                        return Html::a('<p>库存记录</p>', [
                            '/p3s/warehouse-note-item',
                            'WarehouseNoteItemSearch[combination_id]' => $model->id
                        ], [
                            'title' => Yii::t('app', 'Info'),
                            'data-pjax' => '0',
                            'target' => '_blank',
                        ]);
                    },
                ]
            ],

        ],
    ]); ?>

</div>

<?php
\yii\bootstrap\Modal::begin([
    'id' => 'combination-edit',
    'size' => 'modal-lg',
    'options' => [
        'tabindex' => false
    ],
]);

\yii\bootstrap\Modal::end();

$js = "";

$js .= "jQuery(document).off('click', 'a.combination').on('click', 'a.combination', function(e) {
            e.preventDefault();
            jQuery('#combination-edit').modal('show').find('.modal-content').html('" . Yii::t('app.c2', 'Loading...') . "').load(jQuery(e.currentTarget).attr('href'));
        });";

$js .= "jQuery(document).off('click', 'a.delete-combination').on('click', 'a.delete-combination', function(e) {
                e.preventDefault();
                var lib = window['krajeeDialog'];
                var url = jQuery(e.currentTarget).attr('href');
                lib.confirm('" . Yii::t('app.c2', 'Are you sure delete it?') . "', function (result) {
                    if (!result) {
                        return;
                    }
                    
                    jQuery.ajax({
                            url: url,
                            success: function(data) {
                                var lifetime = 6500;
                                if(data._meta.result == '" . cza\base\models\statics\OperationResult::SUCCESS . "'){
                                    // jQuery('#combination-grid').trigger('" . OperationEvent::REFRESH . "');
                                    jQuery('#combination-refresh').click();
                                }
                                else{
                                  lifetime = 16500;
                                }
                                jQuery.msgGrowl ({
                                        type: data._meta.type, 
                                        title: '" . Yii::t('cza', 'Tips') . "',
                                        text: data._meta.message,
                                        position: 'top-center',
                                        lifetime: lifetime,
                                });
                            },
                            error :function(data){alert(data._meta.message);}
                    });
                });
            });";

$this->registerJs($js);

?>
