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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
            '{export}',
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
            // 'type',
            'label',
            [
                'attribute' => 'type',
                'format' => 'html',
                'value' => function ($model) {
                    return \common\models\c2\statics\WarehouseCommitNoteType::getColorLabel($model->type);
                },
                'filter' => \common\models\c2\statics\WarehouseCommitNoteType::getHashMap('id', 'label')
            ],
            // 'note_id',
            // [
            //     'attribute' => 'note_id',
            //     'value' => function ($model) {
            //         return $model->getNoteByType($model->type)->code;
            //     },
            // ],
            'note_code',
            // 'warehouse_id',
            [
                'attribute' => 'warehouse_id',
                'value' => function ($model) {
                    return !is_null($model->warehouse) ? $model->warehouse->name : '';
                },
                'filter' => \common\models\c2\entity\Warehouse::getHashMap('id', 'name')
            ],
            // 'receiver_name',
            // 'updated_by',
            // 'created_by',
            [
                'attribute' => 'created_by',
                'value' => function ($model) {
                    return !is_null($model->creator) ? $model->creator->profile->fullname : '';
                },
            ],
            // 'memo:ntext',
            // 'state',
            // 'status',
            // 'position',
            // 'created_at',
            'updated_at',
            [
                'attribute' => 'state',
                // 'class' => '\kartik\grid\EditableColumn',
                // 'editableOptions' => [
                //     'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                //     'formOptions' => ['action' => Url::toRoute('editColumn')],
                //     'data' => EntityModelStatus::getHashMap('id', 'label'),
                //     'displayValueConfig' => EntityModelStatus::getHashMap('id', 'label'),
                // ],
                'filter' => \common\models\c2\statics\WarehouseCommitState::getHashMap('id', 'label'),
                'value' => function ($model) {
                    return \common\models\c2\statics\WarehouseCommitState::getLabel($model->state);
                }
            ],
            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a(Yii::t('app.c2', 'View'), [
                            \common\models\c2\statics\WarehouseCommitNoteType::getData($model->type, 'viewUrl'),
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
    ]); ?>

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

$js .= "jQuery(document).off('click', 'a.view').on('click', 'a.view', function(e) {
            e.preventDefault();
            jQuery('#content-edit').modal('show').find('.modal-content').html('" . Yii::t('app.c2', 'Loading...') . "').load(jQuery(e.currentTarget).attr('href'));
        });";


$this->registerJs($js);

?>