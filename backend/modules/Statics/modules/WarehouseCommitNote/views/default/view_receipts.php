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

<div class="warehouse-commit-note-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'pjax' => true,
        'hover' => true,
        // 'showPageSummary' => true,
        'panel' => ['type' => GridView::TYPE_INFO, 'heading' => Yii::t('app.c2', 'Items')],
        'toolbar' => [

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
            // [
            //     'attribute' => 'type',
            //     'value' => function ($model) {
            //         return \common\models\c2\statics\WarehouseCommitNoteType::getLabel($model->type);
            //     }
            // ],
            // 'note_id',
            'label',
            // 'warehouse_id',
            [
                'label' => Yii::t('app.c2', 'Sku'),
                'value' => function ($model) {
                    return !is_null($model->product) ? $model->product->sku : '';
                }
            ],
            [
                'label' => Yii::t('app.c2', 'Name'),
                'value' => function ($model) {
                    return !is_null($model->product) ? $model->product->name : '';
                }
            ],
            [
                'label' => Yii::t('app.c2', 'Label'),
                'value' => function ($model) {
                    return !is_null($model->product) ? $model->product->label : '';
                }
            ],
            [
                'label' => Yii::t('app.c2', 'Value'),
                'value' => function ($model) {
                    return !is_null($model->product) ? $model->product->value : '';
                }
            ],
            'number',
            // 'updated_by',
            'memo:ntext',
            // 'state',
            // 'status',
            // 'position',
            'created_at',
            // 'updated_at',
            [
                'attribute' => 'state',
                'value' => function ($model) {
                    return \common\models\c2\statics\WarehouseCommitState::getLabel($model->state);
                }
            ],
        ],
    ]);


    ?>

</div>

