<?php

use cza\base\widgets\ui\common\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\WarehouseCommitNoteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Warehouse Commit Notes');
$this->params['breadcrumbs'][] = $this->title;
?>


    <div class="well warehouse-commit-note-index">

        <div style="background-color: #d0e9c6;margin-bottom: 20px;">
            <?php echo $this->render('print', ['model' => $receiptNote]) ?>
        </div>

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'id' => $model->getPrefixName('grid'),
            'pjax' => true,
            'hover' => true,
            'showPageSummary' => true,
            'panel' => ['type' => GridView::TYPE_INFO, 'heading' => Yii::t('app.c2', 'Items')],
            'toolbar' => [
                [
                    'content' =>
                        Html::a('<i class="glyphicon glyphicon-plus"></i>', ['edit', 'note_id' => $receiptNote->id], [
                            'class' => 'btn btn-success edit',
                            'title' => Yii::t('app.c2', 'Add'),
                            'data-pjax' => '0',
                        ]) . ' ' .
                        // Html::button('<i class="glyphicon glyphicon-remove"></i>', [
                        //     'class' => 'btn btn-danger',
                        //     'title' => Yii::t('app.c2', 'Delete Selected Items'),
                        //     'onClick' => "jQuery(this).trigger('" . OperationEvent::DELETE_BY_IDS . "', {url:'" . Url::toRoute('multiple-delete') . "'});",
                        // ]) . ' ' .
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', Url::current(), [
                            'class' => 'btn btn-default',
                            'id' => 'refresh',
                            'title' => Yii::t('app.c2', 'Reset Grid')
                        ]),
                ],
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
                // 'type',
                [
                    'attribute' => 'type',
                    'value' => function ($model) {
                        return \common\models\c2\statics\WarehouseCommitNoteType::getLabel($model->type);
                    }
                ],
                // 'note_id',
                'label',
                'note_code',
                // 'warehouse_id',
                [
                    'attribute' => 'warehouse_id',
                    'value' => function ($model) {
                        return !is_null($model->warehouse) ? $model->warehouse->name : '';
                    }
                ],
                // 'receiver_name',
                // 'updated_by',
                // 'created_by',
                [
                    'attribute' => 'created_by',
                    'value' => function ($model) {
                        return $model->creator->username;
                    }
                ],
                'memo:ntext',
                // 'state',
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
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'width' => '200px',
                    'template' => '{update} {commit} {view}',
                    'visibleButtons' => [
                        'update' => function ($model) {
                            return ($model->state == \common\models\c2\statics\WarehouseCommitState::INIT);
                        },
                        'commit' => function ($model) {
                            return ($model->state == \common\models\c2\statics\WarehouseCommitState::INIT);
                        },
                        'view' => function ($model) {
                            return ($model->state == \common\models\c2\statics\WarehouseCommitState::COMMIT);
                        },
                    ],
                    'buttons' => [
                        'update' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit', 'id' => $model->id], [
                                'title' => Yii::t('app', 'Info'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-default btn-xs edit',
                            ]);
                        },
                        'commit' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'Commit'), ['commit', 'id' => $model->id, 'note_id' => $model->note_id], [
                                'title' => Yii::t('app.c2', 'Commit'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-danger btn-xs commit',
                            ]);
                        },
                        'view' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'View'), [
                                'view',
                                'commit_id' => $model->id
                            ], [
                                'title' => Yii::t('app.c2', 'View'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-info btn-xs view',
                            ]);
                        },
                    ]
                ],

            ],
        ]);

        echo Html::beginTag('div', ['class' => 'box-footer']);
        echo Html::a('<i class="fa fa-arrow-left"></i> ' . Yii::t('app.c2', 'Go Back'), ['/p3s/processing/receipt-note'], ['data-pjax' => '0', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Go Back'),]);
        echo Html::endTag('div');

        ?>

    </div>

<?php
\yii\bootstrap\Modal::begin([
    'id' => 'content-edit',
    'size' => 'modal-lg',
    'options' => [
        'tabindex' => false
    ],
]);

\yii\bootstrap\Modal::end();

$js = "";

$js .= "jQuery(document).off('click', 'a.edit').on('click', 'a.edit', function(e) {
            e.preventDefault();
            jQuery('#content-edit').modal('show').find('.modal-content').html('" . Yii::t('app.c2', 'Loading...') . "').load(jQuery(e.currentTarget).attr('href'));
        });";

$js .= "jQuery(document).off('click', 'a.view').on('click', 'a.view', function(e) {
            e.preventDefault();
            jQuery('#content-edit').modal('show').find('.modal-content').html('" . Yii::t('app.c2', 'Loading...') . "').load(jQuery(e.currentTarget).attr('href'));
        });";

$js .= "jQuery(document).off('click', 'a.commit').on('click', 'a.commit', function(e) {
                e.preventDefault();
                var lib = window['krajeeDialog'];
                var url = jQuery(e.currentTarget).attr('href');
                lib.confirm('" . Yii::t('app.c2', 'Are you sure? This action can not reverse.') . "', function (result) {
                    if (!result) {
                        return;
                    }
                    jQuery.ajax({
                            url: url,
                            success: function(data) {
                                var lifetime = 6500;
                                if(data._meta.result == '" . cza\base\models\statics\OperationResult::SUCCESS . "'){
                                    // jQuery('#{$model->getPrefixName('grid')}').trigger('" . OperationEvent::REFRESH . "');
                                    jQuery('#refresh').click();
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