<?php

use cza\base\models\statics\OperationResult;
use cza\base\widgets\ui\common\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\ProductionConsumptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Production Consumptions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="well production-consumption-index">

    <?php

    // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'id' => $model->getPrefixName('grid'),
        'pjax' => true,
        'hover' => true,
        'showPageSummary' => true,
        'panel' => ['type' => GridView::TYPE_PRIMARY, 'heading' => Yii::t('app.c2', 'Items')],
        'exportConfig' => [],
        'toolbar' => [
            [
                'content' =>
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', Url::current(), [
                        'class' => 'btn btn-default',
                        'title' => Yii::t('app.c2', 'Reset Grid')
                    ]) .
                    Html::a(Yii::t('app.c2', 'Production Consumption Print'), [
                        '/pam/production-schedule/default/print',
                        'id' => $scheduleId
                    ], [
                        'title' => Yii::t('app.c2', 'Production Consumption Print'),
                        'data-pjax' => '0',
                        'class' => 'btn btn-info ',
                        'target' => '_blank'
                    ])
                ,
            ],
            // $fullExportMenu,
            '{toggleData}',
        ],
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
            // 'schedule_id',
            // 'schedule_item_id',
            // 'need_product_id',
            'need_product_sku',
            'need_product_name',
            'need_product_label',
            'need_product_value',
            // 'need_number',
            [
                'label' => Yii::t('app.c2', 'Measure'),
                'value' => function ($model) {
                    return !is_null($model->product->measure) ? $model->product->measure->name : '';
                }
            ],
            [
                'attribute' => 'need_sum',
                'class' => '\kartik\grid\EditableColumn',
                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'formOptions' => ['action' => Url::toRoute('editColumn')],
                ],
            ],
            // 'need_sum',
            // 'send_sum',
            // [
            //     'attribute' => 'send_sum',
            //     'class' => '\kartik\grid\EditableColumn',
            //     'editableOptions' => [
            //         'inputType' => \kartik\editable\Editable::INPUT_TEXT,
            //         'formOptions' => ['action' => Url::toRoute('editColumn')],
            //     ],
            // ],
            'memo',
            // 'state',
            // 'status',
            // 'position',
            // 'created_at',
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


        ],
    ]);

    echo Html::beginTag('div', ['class' => 'box-footer']);
    echo Html::a('<i class="fa fa-arrow-left"></i> ' . Yii::t('app.c2', 'Go Back'), '/pam/production-schedule', ['data-pjax' => '0', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Go Back'),]);
    echo Html::endTag('div');


    ?>

</div>
