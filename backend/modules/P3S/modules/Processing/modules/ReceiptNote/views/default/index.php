<?php

use cza\base\widgets\ui\common\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\InventoryReceiptNoteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Inventory Receipt Notes');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="well inventory-receipt-note-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'id' => $model->getPrefixName('grid'),
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
                '{export}',
                '{toggleData}',
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
                // 'type',
                'code',
                'label',
                // 'warehouse_id',
                // 'supplier_id',
                [
                    'attribute' => 'supplier_id',
                    'value' => function ($model) {
                        return $model->supplier->name;
                    },
                    'filter' => \common\models\c2\entity\Supplier::getHashMap('id', 'name')
                ],
                // 'arrival_date',
                // 'occurrence_date',
                // 'arrival_number',
                // 'buyer_name',
                // 'dept_manager_name',
                // 'financial_name',
                // 'receiver_name',
                // 'grand_total',
                // 'memo:ntext',
                [
                    'attribute' => 'memo',
                    'format' => 'html',
                ],
                // 'remote_ip',
                // 'updated_by',
                // 'created_by',
                [
                    'attribute' => 'created_by',
                    'value' => function ($model) {
                        return $model->creator->profile->fullname;
                    }
                ],
                // 'state',
                // 'status',
                // 'position',
                // 'updated_at',
                'created_at',
                // [
                //     'attribute' => 'state',
                //     'value' => function ($model) {
                //         return \common\models\c2\statics\InventoryReceiptNoteState::getLabel($model->state);
                //     },
                // ],
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
                    'template' => '{commit-note}',
                    'visibleButtons' => [
                        'commit-note' => function ($model) {
                            return ($model->state == \common\models\c2\statics\InventoryReceiptNoteState::PROCESSING);
                        },
                    ],
                    'buttons' => [
                        'commit-note' => function ($url, $model, $key) {
                            return Html::a(Yii::t('app.c2', 'Commit Note'), [
                                '/p3s/warehouse/commit-note/receipt',
                                'WarehouseCommitNoteSearch[note_id]' => $model->id,
                                'WarehouseCommitNoteSearch[type]' => \common\models\c2\statics\WarehouseCommitNoteType::TYPE_RECEIPT,
                            ], [
                                'title' => Yii::t('app.c2', 'Commit Note'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-warning btn-xs',
                            ]);
                        },
                    ]
                ],

            ],
        ]);
        ?>

    </div>
<?php


$js = "";

$this->registerJs($js);
?>