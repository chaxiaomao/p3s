<?php

use cza\base\models\statics\OperationResult;
use cza\base\widgets\ui\common\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\ProductionCommitNoteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Production Commit Notes');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="well production-commit-note-index">

    <div style="background-color: #f3c17d; margin-bottom: 10px">
        <div class="row">
            <div class="col-xs-3">生产编号：<?= $schedule->code ?></div>
            <div class="col-xs-3">
                生产类型：<?= \common\models\c2\statics\ProductionScheduleType::getLabel($schedule->type) ?></div>
            <div class="col-xs-3">标签：<?= $schedule->label ?></div>
            <div class="col-xs-3">发生日期：<?= date('Y-m-d', strtotime($schedule->occurrence_date)) ?></div>
            <div class="col-xs-3">完成日期：<?= date('Y-m-d', strtotime($schedule->financial_name)) ?></div>
        </div>

        <table class="table table-bordered mt10">

            <tr class="tc">
                <td class="box120">产品编号</td>
                <td class="box120">名称</td>
                <td class="box120">型号</td>
                <td class="box120">生产数量</td>
                <td class="box120">单位</td>
                <td class="memo">备注</td>
            </tr>

            <?php foreach ($schedule->scheduleItems as $item): ?>
                <tr class="tc">
                    <td class=""><?= $item->product_sku ?></td>
                    <td class=""><?= $item->product_name ?></td>
                    <td class=""><?= $item->combination_name ?></td>
                    <td class=""><?= $item->production_sum ?></td>
                    <td class=""><?= !is_null($item->product->measure) ? $item->product->measure->name : '' ?></td>
                    <td class=""><?= $item->memo ?></td>
                </tr>

            <?php endforeach; ?>

        </table>

        <div class="container-fluid">
            <p>备注：<?= $schedule->memo ?></p>
        </div>
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
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['edit', 'schedule_id' => $schedule->id], [
                        'class' => 'btn btn-success edit',
                        'title' => Yii::t('app.c2', 'Add'),
                        'data-pjax' => '0',
                    ]) . '' .
                    Html::a('<i class="glyphicon glyphicon-adjust">' . Yii::t('app.c2', 'All Finish') . '</i>', ['all-finish', 'id' => $schedule->id], [
                        'class' => 'btn btn-danger all-finish',
                        'title' => Yii::t('app.c2', 'All Finish'),
                        'data-pjax' => '0',
                    ])
                    // Html::button('<i class="glyphicon glyphicon-remove"></i>', [
                    //     'class' => 'btn btn-danger',
                    //     'title' => Yii::t('app.c2', 'Delete Selected Items'),
                    //     'onClick' => "jQuery(this).trigger('" . OperationEvent::DELETE_BY_IDS . "', {url:'" . Url::toRoute('multiple-delete') . "'});",
                    // ]) . ' ' .
                    . ' ' .
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', Url::current(), [
                        'id' => 'refresh',
                        'class' => 'btn btn-default',
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
            'type',
            [
                'attribute' => 'type',
                'value' => function ($model) {
                    return \common\models\c2\statics\ProductionCommitNoteType::getLabel($model->type);
                },
            ],
            // 'schedule_id',
            'label',
            // 'memo:ntext',
            [
                'attribute' => 'label',
                'format' => 'html'
            ],
            'commit_at',
            [
                'attribute' => 'created_by',
                'value' => function ($model) {
                    return !is_null($model->creator) ? $model->creator->username : '';
                },
            ],
            // 'updated_by',
            // 'created_by',
            // 'state',
            // 'status',
            // 'position',
            // 'updated_at',
            // 'created_at',
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
                'class' => \common\widgets\grid\ActionColumn::className(),
                'width' => '150px',
                'template' => '{update} {delete} {commit}',
                'visibleButtons' => [
                    'update' => function ($model) {
                        return ($model->state == \common\models\c2\statics\ProductionCommitNoteState::INIT);
                    },
                    'delete' => function ($model) {
                        return ($model->state == \common\models\c2\statics\ProductionCommitNoteState::INIT);
                    },
                    'commit' => function ($model) {
                        return ($model->state == \common\models\c2\statics\ProductionCommitNoteState::INIT);
                    },
                ],
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', [
                            '/pam/production-commit-note/mixture-commit-note/edit',
                            'id' => $model->id,
                            'schedule_id' => $model->schedule_id
                        ], [
                            'title' => Yii::t('app', 'Info'),
                            'data-pjax' => '0',
                            'class' => 'edit'
                        ]);
                    },
                    'commit' => function ($url, $model, $key) {
                        return Html::a(Yii::t('app.c2', 'Commit Warehouse'), [
                            'commit',
                            'id' => $model->id,
                        ], [
                            'title' => Yii::t('app.c2', 'Commit Warehouse'),
                            'data-pjax' => '0',
                            'class' => 'btn btn-success btn-xs commit'
                        ]);
                    },
                ]
            ],

        ],
    ]);

    echo Html::beginTag('div', ['class' => 'box-footer']);
    echo Html::a('<i class="fa fa-arrow-left"></i> ' . Yii::t('app.c2', 'Go Back'), '/pam/mixture-schedule', ['data-pjax' => '0', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Go Back'),]);
    // echo Html::a('<i class="fa fa-window-close-o"></i> ' . Yii::t('app.c2', 'Close'), ['index'], ['data-pjax' => '0', 'data-dismiss' => 'modal', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Close'),]);
    echo Html::endTag('div');

    ?>

</div>
<?php
\yii\bootstrap\Modal::begin([
    'id' => 'edit-edit',
    'size' => 'modal-lg',
    'options' => [
        'tabindex' => false
    ],
]);

$js = "jQuery(document).off('click', 'a.edit').on('click', 'a.edit', function(e) {
            e.preventDefault();
            jQuery('#edit-edit').modal('show').find('.modal-content').html('" . Yii::t('app.c2', 'Loading...') . "').load(jQuery(e.currentTarget).attr('href'));
        });";
$js .= "jQuery(document).off('click', 'a.commit').on('click', 'a.commit', function(e) {
                e.preventDefault();
                var lib = window['krajeeDialog'];
                var url = jQuery(e.currentTarget).attr('href');
                lib.confirm('" . Yii::t('app.c2', 'Are you sure?') . "', function (result) {
                    if (!result) {
                        return;
                    }
                    jQuery.ajax({
                            url: url,
                            success: function(data) {
                                var lifetime = 6500;
                                if(data._meta.result == '" . cza\base\models\statics\OperationResult::SUCCESS . "'){
                                    jQuery('#{$model->getPrefixName('grid')}').trigger('" . OperationEvent::REFRESH . "');
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
$js .= "jQuery(document).off('click', 'a.all-finish').on('click', 'a.all-finish', function(e) {
                e.preventDefault();
                var lib = window['krajeeDialog'];
                var url = jQuery(e.currentTarget).attr('href');
                lib.confirm('" . Yii::t('app.c2', 'Are you sure?') . "', function (result) {
                    if (!result) {
                        return;
                    }
                    jQuery.ajax({
                            url: url,
                            success: function(data) {
                                var lifetime = 6500;
                                if(data._meta.result == '" . cza\base\models\statics\OperationResult::SUCCESS . "'){
                                    jQuery('#{$model->getPrefixName('grid')}').trigger('" . OperationEvent::REFRESH . "');
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
