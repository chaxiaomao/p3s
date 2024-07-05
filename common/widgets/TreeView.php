<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015 - 2017
 * @package   yii2-tree-manager
 * @version   1.0.8
 */

namespace common\widgets;

use Closure;
use kartik\base\Config;
use kartik\base\Widget;
use kartik\dialog\Dialog;
use kartik\tree\models\Tree;
use Yii;
use yii\base\InvalidConfigException;
use yii\bootstrap\BootstrapPluginAsset;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\tree\Module;

/**
 * An enhanced tree view widget for Yii Framework 2 that allows management and manipulation of hierarchical data using
 * nested sets.
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since  1.0
 */
class TreeView extends \kartik\tree\TreeView {
    
    public $softDelete = false;

    public $mainTemplate = <<< HTML
<div class="row">
    <div class="col-sm-4">
        {wrapper}
    </div>
    <div class="col-sm-8">
        {detail}
    </div>
</div>
HTML;

    /**
     * Initializes and validates the tree view configurations
     *
     * @throws InvalidConfigException
     */
    protected function initTreeView() {
        $this->validateSourceData();
        $this->_module = Yii::$app->controller->module;
        if (empty($this->emptyNodeMsg)) {
            $this->emptyNodeMsg = Yii::t(
                            'kvtree', 'No valid tree nodes are available for display. Use toolbar buttons to add tree nodes.'
            );
        }
        $this->_hasBootstrap = $this->showTooltips;
        $this->breadcrumbs += [
            'depth' => null,
            'glue' => ' &raquo; ',
            'activeCss' => 'kv-crumb-active',
            'untitled' => Yii::t('kvtree', 'Untitled'),
        ];
    }

    /**
     * Validation of source query data
     *
     * @throws InvalidConfigException
     */
    protected function validateSourceData() {
        if (empty($this->query) || !$this->query instanceof ActiveQuery) {
            throw new InvalidConfigException(
            "The 'query' property must be defined and must be an instance of '" . ActiveQuery::className() . "'."
            );
        }
        $class = isset($this->query->modelClass) ? $this->query->modelClass : null;
        if (empty($class) || !is_subclass_of($class, ActiveRecord::className())) {
            throw new InvalidConfigException("The 'query' must be implemented using 'ActiveRecord::find()' method.");
        }
//        $trait = 'kartik\tree\models\TreeTrait';
//        if (!self::usesTrait($class, $trait)) {
//            throw new InvalidConfigException(
//            "The model class '{$class}' for the 'query' must use the trait '{$trait}' or extend from '" .
//            Tree::className() . "''."
//            );
//        }
    }

    public function renderDetail() {
        /**
         * @var Tree $modelClass
         * @var Tree $node
         */
        $modelClass = $this->query->modelClass;
        $node = $this->displayValue ? $modelClass::findOne($this->displayValue) : null;
        $msg = null;
        if (empty($node)) {
            $msg = Html::tag('div', $this->emptyNodeMsg, $this->emptyNodeMsgOptions);
            $node = new $modelClass;
        }
        $iconTypeAttribute = ArrayHelper::getValue($this->_module->dataStructure, 'iconTypeAttribute', 'icon_type');
        if ($this->_iconsList !== false) {
            $node->$iconTypeAttribute = ArrayHelper::getValue($this->iconEditSettings, 'type', self::ICON_CSS);
        }
        $params = $this->_module->treeStructure + $this->_module->dataStructure + [
            'node' => $node,
            'action' => $this->nodeActions[Module::NODE_SAVE],
            'formOptions' => $this->nodeFormOptions,
            'modelClass' => $modelClass,
            'currUrl' => Yii::$app->request->url,
            'isAdmin' => $this->isAdmin,
            'iconsList' => $this->_iconsList,
            'softDelete' => $this->softDelete,
            'allowNewRoots' => $this->allowNewRoots,
            'showFormButtons' => $this->showFormButtons,
            'showIDAttribute' => $this->showIDAttribute,
            'nodeView' => $this->nodeView,
            'nodeAddlViews' => $this->nodeAddlViews,
            'nodeSelected' => $this->_nodeSelected,
            'breadcrumbs' => $this->breadcrumbs,
            'noNodesMessage' => $msg,
        ];
        $content = $this->render($this->nodeView, ['model' => $node, 'params' => $params]);

        return Html::tag('div', $content, $this->detailOptions);
    }

}
