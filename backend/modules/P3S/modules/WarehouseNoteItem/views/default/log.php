<?php

use cza\base\widgets\ui\common\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\WarehouseNoteItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Warehouse Note Items Log');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="well warehouse-note-item-index">


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
            '{toggleData}',
        ],
        'exportConfig' => [],
        'columns' => [
            // 'id',
            // 'note_id',
            // 'product_id',
            [
                'attribute' => 'warehouse_note_type',
                'filter' => \common\models\c2\statics\WarehouseNoteType::getHashMap('id', 'label'),
                'value' => function ($model) {
                    return \common\models\c2\statics\WarehouseNoteType::getLabel($model->owner->type);
                }
            ],
            'owner.ref_note_code',
            'product_name',
            'product_sku',
            'measure.name',

            // 'owner.creator.profile.fullname',
            // 'owner.updator.profile.fullname',
            // 'product_label',
            // 'product_value',
            // 'combination_id',
            // 'combination_name',
            // 'package_id',
            // 'package_name',
            // 'pieces',
            // 'number',
            [
                'format' => 'html',
                'attribute' => 'number',
                'value' => function ($model) {

                    if ($model->owner->type == \common\models\c2\statics\WarehouseNoteType::MODIFY_BY_USER) {
                        return "<span style='color: #7c7c7c'>手动更新{$model->number}</span>";
                    }
                    return $model->isReceipt() ? "<span style='color: #00a65a'>进仓{$model->number}</span>" : "<span style='color: red'>出仓{$model->number}</span>";
                }
            ],
            'price',
            'subtotal',
            [
                'attribute' => 'owner.creator.profile.fullname',
                'label' => Yii::t('app.c2', 'Created By'),
            ],
            [
                'attribute' => 'owner.updator.profile.fullname',
                'label' => Yii::t('app.c2', 'Updated By'),
            ],
            'memo',
            'created_at',
            [
                'attribute' => 'status',
                'filter' => \common\models\c2\statics\WarehouseNoteItemStatus::getHashMap('id', 'label'),
                'value' => function ($model) {
                    return \common\models\c2\statics\WarehouseNoteItemStatus::getLabel($model->status);
                }
            ],
            // 'status',
            // 'position',
            // 'updated_at',
            // [
            //     'attribute' => 'status',
            //     'contentOptions' => ['style' => 'width:100px; white-space: normal;'],
            //
            //     // 'class' => '\kartik\grid\EditableColumn',
            //     // 'editableOptions' => [
            //     //     'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
            //     //     'formOptions' => ['action' => Url::toRoute('editColumn')],
            //     //     'data' => \common\models\c2\statics\WarehouseNoteItemStatus::getHashMap('id', 'label'),
            //     //     'displayValueConfig' => \common\models\c2\statics\WarehouseNoteItemStatus::getHashMap('id', 'label'),
            //     // ],
            //     'filter' => EntityModelStatus::getHashMap('id', 'label'),
            //     'value' => function ($model) {
            //         return \common\models\c2\statics\WarehouseNoteItemStatus::getLabel($model->status);
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
    ]);
    echo Html::beginTag('div', ['class' => 'box-footer']);
    // echo Html::a('<i class="fa fa-arrow-left"></i> ' . Yii::t('app.c2', 'Go Back'), ['javascript:window.history.back()'], [ 'data-pjax' => '0', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Go Back'),]);
    echo '<a href="javascript:window.history.back()" class="btn btn-default pull-right"><i class="fa fa-arrow-left">返回</i></a>';
    echo Html::endTag('div');

    ?>

</div>
<script>

</script>