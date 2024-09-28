<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015 - 2017
 * @package   yii2-tree-manager
 * @version   1.0.8
 */
use kartik\form\ActiveForm;
use kartik\tree\Module;
use kartik\tree\TreeView;
use kartik\tree\models\Tree;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use kartik\builder\Form;
use cza\base\models\statics\EntityModelStatus;
use backend\modules\Test\modules\UserCase\modules\Category\widgets\EntityDetail;

/**
 * @var View       $this
 * @var Tree       $node
 * @var ActiveForm $form
 * @var array      $formOptions
 * @var string     $keyAttribute
 * @var string     $nameAttribute
 * @var string     $iconAttribute
 * @var string     $iconTypeAttribute
 * @var string     $iconsList
 * @var string     $action
 * @var array      $breadcrumbs
 * @var array      $nodeAddlViews
 * @var mixed      $currUrl
 * @var boolean    $showIDAttribute
 * @var boolean    $showFormButtons
 * @var boolean    $allowNewRoots
 * @var string     $nodeSelected
 * @var array      $params
 * @var string     $keyField
 * @var string     $nodeView
 * @var string     $noNodesMessage
 * @var boolean    $softDelete
 * @var string     $modelClass
 */
?>

<?php
/**
 * SECTION 1: Initialize node view params & setup helper methods.
 */
?>
<?php
extract($params);
$session = Yii::$app->has('session') ? Yii::$app->session : null;

// parse parent key
if ($noNodesMessage) {
    $parentKey = '';
} elseif (empty($parentKey)) {
    $parent = $node->parents(1)->one();
    $parentKey = empty($parent) ? '' : Html::getAttributeValue($parent, $keyAttribute);
}

// tree manager module
$module = Yii::$app->controller->module;

// active form instance
$form = ActiveForm::begin(['action' => $action, 'options' => $formOptions]);

// helper function to show alert
$showAlert = function ($type, $body = '', $hide = true) {
    $class = "alert alert-{$type}";
    if ($hide) {
        $class .= ' hide';
    }
    return Html::tag('div', '<div>' . $body . '</div>', ['class' => $class]);
};
?>

<?php
/**
 * SECTION 2: Initialize hidden attributes. In case you are extending this and creating your own view, it is mandatory
 * to set all these hidden inputs as defined below.
 */
?>
<?= Html::hiddenInput('treeNodeModify', $node->isNewRecord) ?>
<?= Html::hiddenInput('parentKey', $parentKey) ?>
<?= Html::hiddenInput('currUrl', $currUrl) ?>
<?= Html::hiddenInput('modelClass', $modelClass) ?>
<?= Html::hiddenInput('nodeSelected', $nodeSelected) ?>

<?php
/**
 * SECTION 3: Hash signatures to prevent data tampering. In case you are extending this and creating your own view, it
 * is mandatory to include this section below.
 */
?>
<?php
$security = Yii::$app->security;
$id = $node->isNewRecord ? null : $node->$keyAttribute;

// save signature
$dataToHash = !!$node->isNewRecord . $currUrl . $modelClass;
echo Html::hiddenInput('treeSaveHash', $security->hashData($dataToHash, $module->treeEncryptSalt));

// manage signature
if (array_key_exists('depth', $breadcrumbs) && $breadcrumbs['depth'] === null) {
    $breadcrumbs['depth'] = '';
}
$icons = is_array($iconsList) ? array_values($iconsList) : $iconsList;
$dataToHash = $modelClass . !!$isAdmin . !!$softDelete . !!$showFormButtons . !!$showIDAttribute .
        $currUrl . $nodeView . $nodeSelected . Json::encode($formOptions) .
        Json::encode($nodeAddlViews) . Json::encode($icons) . Json::encode($breadcrumbs);
echo Html::hiddenInput('treeManageHash', $security->hashData($dataToHash, $module->treeEncryptSalt));

// remove signature
$dataToHash = $modelClass . $softDelete;
echo Html::hiddenInput('treeRemoveHash', $security->hashData($dataToHash, $module->treeEncryptSalt));

// move signature
$dataToHash = $modelClass . $allowNewRoots;
echo Html::hiddenInput('treeMoveHash', $security->hashData($dataToHash, $module->treeEncryptSalt));
?>

<?php
/**
 * BEGIN VALID NODE DISPLAY
 */
?>
<?php if (!$noNodesMessage): ?>
    <?php
    $isAdmin = ($isAdmin == true || $isAdmin === "true"); // admin mode flag
    $inputOpts = [];                                      // readonly/disabled input options for node
    $flagOptions = ['class' => 'kv-parent-flag'];         // node options for parent/child

    if ($node->isNewRecord) {
        $options['value'] = Yii::t('app.c2', '(new)');
    }

    /**
     * initialize for create or update
     */
    $depth = ArrayHelper::getValue($breadcrumbs, 'depth');
    $glue = ArrayHelper::getValue($breadcrumbs, 'glue');
    $activeCss = ArrayHelper::getValue($breadcrumbs, 'activeCss');
    $untitled = ArrayHelper::getValue($breadcrumbs, 'untitled');
    $name = $node->getBreadcrumbs($depth, $glue, $activeCss, $untitled);
    if ($node->isNewRecord && !empty($parentKey) && $parentKey !== TreeView::ROOT_KEY) {
        /**
         * @var Tree $modelClass
         * @var Tree $parent
         */
        $depth = empty($breadcrumbsDepth) ? null : intval($breadcrumbsDepth) - 1;
        if ($depth === null || $depth > 0) {
            $parent = $modelClass::findOne($parentKey);
            $name = $parent->getBreadcrumbs($depth, $glue, null) . $glue . $name;
        }
    }
    if ($node->isReadonly()) {
        $inputOpts['readonly'] = true;
    }
    if ($node->isDisabled()) {
        $inputOpts['disabled'] = true;
    }
    if ($node->isLeaf()) {
        $flagOptions['disabled'] = true;
    }
    ?>
    <?php
    /**
     * SECTION 4: Setup form action buttons.
     */
    ?>
    <div class="kv-detail-heading">
        <?php if (empty($inputOpts['disabled']) || ($isAdmin && $showFormButtons)): ?>
            <div class="pull-right">
                <button type="reset" class="btn btn-default" title="<?= Yii::t('app.c2', 'Reset') ?>">
                    <i class="glyphicon glyphicon-repeat"></i>
                </button>
                <button type="submit" class="btn btn-primary" title="<?= Yii::t('app.c2', 'Save') ?>">
                    <i class="glyphicon glyphicon-floppy-disk"></i>
                </button>
            </div>
        <?php endif; ?>
        <div class="kv-detail-crumbs"><?= $name ?></div>
        <div class="clearfix"></div>
    </div>

    <?php
    /**
     * SECTION 5: Setup alert containers. Mandatory to set this up.
     */
    ?>
    <div class="kv-treeview-alerts">
        <?php
        if ($session && $session->hasFlash('success')) {
            echo $showAlert('success', $session->getFlash('success'), false);
        } else {
            echo $showAlert('success');
        }
        if ($session && $session->hasFlash('error')) {
            echo $showAlert('danger', $session->getFlash('error'), false);
        } else {
            echo $showAlert('danger');
        }
        echo $showAlert('warning');
        echo $showAlert('info');
        ?>
    </div>

    <?php
    $p = $params;
    $p['form'] = $form;
    $p['inputOpts'] = $inputOpts;
    $p['flagOptions'] = $flagOptions;
    echo $this->render("_node_form", $p);
    ?>

    <?php
    /**
     * SECTION 9: Administrator attributes zone.
     */
    ?>
    <?php if ($isAdmin): ?>
        <?php echo $this->render("_node_options", $p); ?>
    <?php endif; ?>

<?php endif; ?>
<?php ActiveForm::end() ?>
