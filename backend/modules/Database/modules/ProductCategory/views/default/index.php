<?php

use kartik\tree\Module;
use common\widgets\TreeView;
use common\models\c2\entity\ProductCategory;
use yii\helpers\Url;

$this->title = Yii::t('app.c2', '{s1} Category', ['s1' => Yii::t('app.c2', 'Product')]);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Category-default-index">
    <?php
    echo TreeView::widget([
        // single query fetch to render the tree
        'query' => ProductCategory::find()->addOrderBy('root, lft'),
        'nodeView' => "/default/_panel_node",
//        'nodeView' => EntityDetail::className(),
        'nodeActions' => [
            Module::NODE_MANAGE => Url::toRoute(['node-manage']),
            Module::NODE_SAVE => Url::toRoute(['node-save']),
            Module::NODE_REMOVE => Url::toRoute(['node-remove']),
            Module::NODE_MOVE => Url::toRoute(['node-move']),
        ],
        'headingOptions' => ['label' => Yii::t('app.c2', 'Categories')],
        'isAdmin' => true, // optional (toggle to enable admin mode)
        'displayValue' => 1, // initial display value
        'showCheckbox' => true,
        'fontAwesome' => true,
        'treeOptions' => [
            "style" => "height:600px",
        ],
        'detailOptions' => [
            'class' => 'treeview-detail',
        ],
        'rootOptions' => [
            'label' => '<i class="fa fa-tree"></i>', // custom root label
            'class' => 'text-success'
        ],
        'cacheSettings' => [
            'enableCache' => false
        ],
        'iconEditSettings' => [
            'show' => 'list',
            'listData' => [
                'folder' => 'Folder',
                'file' => 'File',
                'tags' => 'Tags',
                'tag' => 'Tag',
                'dot-circle-o' => 'Circle',
            ]
        ],
            //'softDelete'      => true,                        // normally not needed to change
            //'cacheSettings'   => ['enableCache' => true]      // normally not needed to change
    ]);
    ?>
</div>


