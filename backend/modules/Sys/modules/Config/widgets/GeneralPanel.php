<?php

namespace backend\modules\Sys\modules\Config\widgets;

use Yii;
use cza\base\widgets\Widget;

/**
 * GeneralPanel Widget
 * 
 * @author Ben Bi <ben@cciza.com>
 * @link http://www.cciza.com/
 * @copyright 2014-2016 CCIZA Software LLC
 * @license
 */
class GeneralPanel extends Widget {

    protected $_tabs = [];
    public $tabTitle = '';
    public $withApiTab = true;
    public $withBusinessTab = true;
    public $withWechatTab = true;
    public $withGeoTab = true;
    public $withPerformanceTab = true;
    public $withGeneralTab = true;
    public $withUrlTab = true;


    public function getTabsId() {
        return 'general-panel-tabs';
    }

    public function getTabItems() {
        $items = [];
        if ($this->withBusinessTab) {
            $items[] = $this->getBusinessTab();
        }
        
        if ($this->withPerformanceTab) {
            $items[] = $this->getPerformanceTab();
        }

        if ($this->withWechatTab) {
            $items[] = $this->getWechatTab();
        }

        if ($this->withGeoTab) {
            $items[] = $this->getGeoTab();
        }

        if ($this->withApiTab) {
            $items[] = $this->getApiTab();
        }
        
        if ($this->withUrlTab) {
            $items[] = $this->getUrlTab();
        }
        
        if ($this->withGeneralTab) {
            $items[] = $this->getGeneralTab();
        }

        $items[] = [
            'label' => '<a href="#" class="text-muted"><i class="fa fa-gear"></i></a>',
            'onlyLabel' => true,
            'headerOptions' => [
                'class' => 'pull-right',
            ],
        ];

        return $items;
    }

    public function getApiTab() {
        if (!isset($this->_tabs['getApiTab'])) {
            $this->_tabs['BusinessTab'] = [
                'label' => Yii::t('app.c2', 'Api Settings'),
                'content' => \backend\modules\Sys\modules\Config\widgets\ApiSettings::widget([]),
                'enable' => true,
            ];
        }

        return $this->_tabs['BusinessTab'];
    }

    public function getBusinessTab() {
        if (!isset($this->_tabs['BusinessTab'])) {
            $this->_tabs['BusinessTab'] = [
                'label' => Yii::t('app.c2', 'Business Settings'),
                'content' => \backend\modules\Sys\modules\Config\widgets\BusinessSettings::widget([]),
                'enable' => true,
            ];
        }

        return $this->_tabs['BusinessTab'];
    }

    public function getWechatTab() {
        if (!isset($this->_tabs['WechatTab'])) {
            $this->_tabs['WechatTab'] = [
                'label' => Yii::t('app.c2', 'Wechat Settings'),
                'content' => \backend\modules\Sys\modules\Config\widgets\WechatSettings::widget([]),
                'enable' => true,
            ];
        }

        return $this->_tabs['WechatTab'];
    }

    public function getGeoTab() {
        if (!isset($this->_tabs['GeoTab'])) {
            $this->_tabs['GeoTab'] = [
                'label' => Yii::t('app.c2', 'Geo Settings'),
                'content' => \backend\modules\Sys\modules\Config\widgets\GeoSettings::widget([]),
                'enable' => true,
            ];
        }

        return $this->_tabs['GeoTab'];
    }

    public function getPerformanceTab() {
        if (!isset($this->_tabs['PerformanceTab'])) {
            $this->_tabs['PerformanceTab'] = [
                'label' => Yii::t('app.c2', 'Performance Settings'),
                'content' => \backend\modules\Sys\modules\Config\widgets\PerformanceSettings::widget([]),
                'enable' => true,
            ];
        }

        return $this->_tabs['PerformanceTab'];
    }

    public function getGeneralTab() {
        if (!isset($this->_tabs['GeneralTab'])) {
            $this->_tabs['GeneralTab'] = [
                'label' => Yii::t('app.c2', 'General Settings'),
                'content' => \backend\modules\Sys\modules\Config\widgets\GeneralSettings::widget([]),
                'enable' => true,
            ];
        }

        return $this->_tabs['GeneralTab'];
    }

    public function getUrlTab(){
        if (!isset($this->_tabs['UrlTab'])) {
            $this->_tabs['UrlTab'] = [
                'label' => Yii::t('app.c2', '3rd Settings'),
                'content' => \backend\modules\Sys\modules\Config\widgets\UrlSettings::widget([]),
                'enable' => true,
            ];
        }

        return $this->_tabs['UrlTab'];
    }

}
