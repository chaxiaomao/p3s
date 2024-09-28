<?php

use cza\base\widgets\ui\common\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\OrderItemConsumptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Order Item Consumptions');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="order-item-consumption-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php echo GridView::widget([
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,

            'pjax' => true,
            'hover' => true,
            'showPageSummary' => true,
            'panel' => ['type' => GridView::TYPE_INFO, 'heading' => Yii::t('app.c2', 'Material Stats')],
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
                // '{export}',
                // '{toggleData}',
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
                // [
                //     'label' => Yii::t('app.c2', 'Product'),
                //     'value' => function ($model) {
                //         return $model->orderItem->product_name;
                //     }
                // ],
                // 'sale_product_sum',
                // 'production_sum',
                // [
                //     'attribute' => 'sale_product_id',
                //     'group' => true,  // enable grouping
                //     'subGroupOf' => 1 // supplier column index is the parent group
                // ],
                // 'id',
                // 'order_id',
                // 'order_item_id',
                // 'need_product_id',
                'need_product_sku',
                'need_product_name',
                'need_product_label',
                'need_product_value',
                'need_number',
                'need_sum',
                // 'sale_product_id',
                'memo',
                [
                    'label' => Yii::t('app.c2', 'Stock Stats'),
                    'format' => 'html',
                    'value' => function ($model) {
                        return $model->getStockStats();
                    }
                ],
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
                [
                    'class' => '\kartik\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', [
                                'view',
                                'OrderItemConsumptionSearch[need_product_id]' => $model->need_product_id,
                            ], [
                                'title' => Yii::t('app', 'View'),
                                'data-pjax' => '0',
                                'class' => 'view',
                            ]);
                        }
                    ]
                ],

            ],
        ]);

        echo Html::beginTag('div', ['class' => 'box-footer']);
        echo Html::a('<i class="fa fa-arrow-left"></i> ' . Yii::t('app.c2', 'Go Back'), 'javascript:history.go(-1)', ['data-pjax' => '0', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Go Back'),]);
        // echo Html::a('<i class="fa fa-window-close-o"></i> ' . Yii::t('app.c2', 'Close'), ['index'], ['data-pjax' => '0', 'data-dismiss' => 'modal', 'class' => 'btn btn-default pull-right', 'title' => Yii::t('app.c2', 'Close'),]);
        echo Html::endTag('div');
        ?>

    </div>
<?php
Modal::begin([
    'id' => 'view-modal',
    'size' => 'modal-lg',
]);
Modal::end();

$js = "";
$js .= "jQuery(document).off('click', 'a.view').on('click', 'a.view', function(e) {
                e.preventDefault();
                jQuery('#view-modal').modal('show').find('.modal-content').html('" . Yii::t('app.c2', 'Loading...') . "').load(jQuery(e.currentTarget).attr('href'));
            });";

$this->registerJs($js);

?>