<?php

namespace backend\modules\Database\modules\ProductCombination\widgets;

use Yii;
use cza\base\widgets\ui\common\part\EntityDetail as DetailWidget;

/**
 * Entity Detail Widget
 *
 * @author Ben Bi <ben@cciza.com>
 * @link http://www.cciza.com/
 * @copyright 2014-2016 CCIZA Software LLC
 * @license
 */
class EntityDetail extends DetailWidget
{
    public $withTranslationTabs = false;

    public $withProfileTab = false;

    public $withAlbumTab = false;

    public function getTabItems()
    {
        $items = [];
        if ($this->withAlbumTab) {
            $items[] = $this->getAlbumTab();
        }
        if ($this->withBaseInfoTab) {
            $items[] = [
                'label' => Yii::t('app.c2', 'Base Information'),
                'content' => $this->controller->renderPartial('_form', ['model' => $this->model,]),
                'active' => true,
            ];
        }
        $items[] = [
            'label' => '<i class="fa fa-th"></i> ' . $this->tabTitle,
            'onlyLabel' => true,
            'headerOptions' => [
                'class' => 'pull-left header',
            ],
        ];
        return $items;
    }

    public function getAlbumTab()
    {
        if (!isset($this->_tabs['ALBUM_TAB'])) {
            if (!$this->model->isNewRecord) {
                $this->_tabs['ALBUM_TAB'] = [
                    'label' => Yii::t('app.c2', '{s1} Album', ['s1' => Yii::t('app.c2', 'Product')]),
                    'content' => $this->controller->renderPartial('/default/_album_form', ['model' => $this->model]),
                    'enable' => true,
                ];
            } else {
                $this->_tabs['ALBUM_TAB'] = [
                    'label' => Yii::t('app.c2', '{s1} Album', ['s1' => Yii::t('app.c2', 'Surface')]),
                    'content' => "",
                    'enable' => false,
                ];
            }
        }

        return $this->_tabs['ALBUM_TAB'];
    }
}