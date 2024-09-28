<?php

namespace common\widgets\grid;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\widgets\grid\assets\ActionColumnAsset;
use kartik\grid\ActionColumn as kvActionColumn ;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class ActionColumn extends kvActionColumn {
    
    
      /**
     * Sets a default button configuration based on the button name (bit different than [[initDefaultButton]] method)
     *
     * @param string $name button name as written in the [[template]]
     * @param string $title the title of the button
     * @param string $icon the meaningful glyphicon suffix name for the button
     */
    protected function setDefaultButton($name, $title, $icon) {
        if (isset($this->buttons[$name])) {
            return;
        }
        $this->buttons[$name] = function ($url) use ($name, $title, $icon) {
            $opts = "{$name}Options";
            $options = ['title' => $title, 'aria-label' => $title, 'data-pjax' => '1'];
            if ($name === 'delete') {
                $item = isset($this->grid->itemLabelSingle) ? $this->grid->itemLabelSingle : Yii::t('kvgrid', 'item');
                $options['data-method'] = 'post';
                $options['data-confirm'] = Yii::t('kvgrid', 'Are you sure to delete this {item}?', ['item' => $item]);
                //fixed
                $pjax = $this->grid->pjax ? true : false;
                $pjaxContainer = $pjax ? $this->grid->pjaxSettings['options']['id'] : '';
                if ($pjax) {
                    $defaults['data-pjax-container'] = $pjaxContainer;
                }
                $css = $this->grid->options['id'] . '-action-del';
                Html::addCssClass($options, $css);
                $view = $this->grid->getView();
                $delOpts = \yii\helpers\Json::encode(
                                [
                                    'css' => $css,
                                    'pjax' => $pjax,
                                    'pjaxContainer' => $pjaxContainer,
                                    'lib' => ArrayHelper::getValue($this->grid->krajeeDialogSettings, 'libName', 'krajeeDialog'),
                                    'msg' => $options['data-confirm'],
                                ]
                );
                ActionColumnAsset::register($view);
                $js = "kvActionDelete({$delOpts});";
                $view->registerJs($js);
                //fixed
            }
            $options = array_replace_recursive($options, $this->buttonOptions, $this->$opts);
            $label = $this->renderLabel($options, $title, ['class' => "glyphicon glyphicon-{$icon}"]);
            $link = Html::a($label, $url, $options);
            if ($this->_isDropdown) {
                $options['tabindex'] = '-1';
                return "<li>{$link}</li>\n";
            } else {
                return $link;
            }
        };
    }

}
