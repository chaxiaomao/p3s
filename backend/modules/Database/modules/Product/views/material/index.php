<?php

use cza\base\widgets\ui\common\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="well product-index">

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
                'content' => yii\bootstrap\ButtonDropdown::widget([
                        'label' => "<i class='glyphicon glyphicon-plus'></i> " . Yii::t("app.c2", "Create"),
                        'encodeLabel' => false,
                        'options' => [
                            'class' => 'btn btn-success',
                        ],
                        'dropdown' => [
                            'items' => [
                                ['label' => \common\models\c2\statics\ProductType::getMaterial(), 'url' => ['edit'], 'linkOptions' => ['data-pjax' => '0', 'id' => 'material']],
                                ['label' => \common\models\c2\statics\ProductType::getProduct(), 'url' => ['edits'], 'linkOptions' => ['data-pjax' => '0']],
                            ],
                        ],
                    ]) .
                    Html::button('<i class="glyphicon glyphicon-remove"></i>', [
                        'class' => 'btn btn-danger',
                        'title' => Yii::t('app.c2', 'Delete Selected Items'),
                        'onClick' => "jQuery(this).trigger('" . OperationEvent::DELETE_BY_IDS . "', {url:'" . Url::toRoute('multiple-delete') . "'});",
                    ]) . ' ' .
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
            'type',
            // 'seo_code',
            'sku',
            'name',
            'label',
            // 'value',
            // 'low_price',
            // 'sales_price',
            // 'cost_price',
            // 'market_price',
            // 'supplier_id',
            // 'currency_id',
            // 'measure_id',
            // 'summary:ntext',
            // 'description:ntext',
            // 'sold_count',
            // 'is_released',
            // 'released_at',
            'created_by',
            [
                'attribute' => 'updated_by',
                'value' => function ($model) {
                    return !is_null($model->updator) ? $model->updator->profile->fullname : '';
                },
            ],
            // 'updated_by',
            // 'status',
            // 'position',
            'created_at',
            // 'updated_at',
            [
                'attribute' => 'status',
                'class' => '\kartik\grid\EditableColumn',
                'editableOptions' => [
                    'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                    'formOptions' => ['action' => Url::toRoute('editColumn')],
                    'data' => EntityModelStatus::getHashMap('id', 'label'),
                    'displayValueConfig' => EntityModelStatus::getHashMap('id', 'label'),
                ],
                'filter' => EntityModelStatus::getHashMap('id', 'label'),
                'value' => function ($model) {
                    return $model->getStatusLabel();
                }
            ],
            [
                'class' => '\kartik\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['edit', 'id' => $model->id], [
                            'title' => Yii::t('app', 'Info'),
                            'data-pjax' => '0',
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
    'size' => 'modal-lg'
]);

\yii\bootstrap\Modal::end();

$js = "";

$js .= "jQuery(document).off('click', '#material').on('click', '#material', function(e) {
            e.preventDefault();
            jQuery('#content-edit').modal('show').find('.modal-content').html('" . Yii::t('app.c2', 'Loading...') . "').load(jQuery(e.currentTarget).attr('href'));
        });";

$this->registerJs($js);

?>