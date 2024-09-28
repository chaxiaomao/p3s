<?php

use cza\base\widgets\ui\common\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use cza\base\models\statics\EntityModelStatus;
use cza\base\models\statics\OperationEvent;
use yii\bootstrap\Modal;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel common\models\c2\search\EntityAttachment */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app.c2', 'File');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= $model->getPrefixName('index') ?>">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    echo GridView::widget([
        'id' => $model->getPrefixName('grid'),
        'dataProvider' => $dataProvider,
        'summary' => Yii::t('app.c2', 'Showing <b>{begin, number}-{end, number}</b> of <b>{totalCount, number}</b> {totalCount, plural, one{{item}} other{{items}}}.'),

        'filterModel' => $searchModel,
        'pjax' => true,
        'hover' => true,
        'showPageSummary' => true,
        'panel' => ['type' => GridView::TYPE_PRIMARY, 'heading' => Yii::t('app.c2', 'Items')],
        'toolbar' => [
            [
                'content' =>
                Html::button('<i class="glyphicon glyphicon-plus"></i>', [
                    'type' => 'button',
                    'title' => Yii::t('app.c2', 'Add'),
                    'class' => 'btn btn-success',
                    'onClick' => "jQuery(this).trigger('" . OperationEvent::CREATE . "', {url:'" . Url::toRoute('edit') . "'});",
                ]) . ' ' .
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
                'detailUrl' => Url::toRoute('detail'),
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
            ],
            'id',
            'entity_id',
            'entity_class',
            'entity_attribute',
            'type',
            // 'name',
            // 'label',
            // 'content:ntext',
            // 'hash',
            // 'extension',
            // 'size',
            // 'mime_type',
            // 'logic_path',
            // 'status',
            // 'position',
            // 'created_at',
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
                'value' => function($model) {
                    return $model->getStatusLabel();
                }
            ],
            ['class' => '\common\widgets\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        $title = Yii::t('app.c2', 'Update');
                        return Html::a(Html::tag('span', '', ['class' => "glyphicon glyphicon-pencil"]), ['edit', 'id' => $model->id], [
                                    'title' => $title,
                                    'aria-label' => $title,
                                    'data-pjax' => '0',
                                    'class' => 'update'
                        ]);
                    },
                ],
            ],
        ],
    ]);
    ?>

    <?php
    Modal::begin([
        'id' => 'entity-attachment-modal',
        'size' => 'modal-lg',
    ]);
    Modal::end();

    $js = "";
    $js .= "jQuery(document).on('" . OperationEvent::CREATE . "', '.entity-attachment-index', function(e, data) {
                    e.preventDefault();
                    jQuery('#entity-attachment-modal').modal('show').find('.modal-content').html('" . Yii::t('app.c2', 'Loading...') . "').load(data.url);
                });";

    $js .= "jQuery(document).on('click', '.entity-attachment-index a.update', function(e) {
                e.preventDefault();
                jQuery('#entity-attachment-modal').modal('show').find('.modal-content').html('" . Yii::t('app.c2', 'Loading...') . "').load(jQuery(e.currentTarget).attr('href'));
            });";

    $this->registerJs($js);
    ?>
</div>
