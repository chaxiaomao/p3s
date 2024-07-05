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

    <div style="background-color: #d0e9c6;margin-bottom: 20px;">
        <?= $this->render('print', ['model' => $model]) ?>
    </div>
    <p style="color: red">仓库送货记录，确认状态再完成订单</p>
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
            'product_sku',
            'product_name',
            'combination_name',
            'package_name',
            'pieces',
            'product_sum',
            'produce_number',
            'stock_number',
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

