<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30
 * Time: 9:33
 */

namespace backend\modules\Sys\modules\Config\widgets;
use Yii;
use cza\base\widgets\Widget;

class TransferPanel extends Widget {
    protected $_tabs = [];
    public $tabTitle = '';
    public $withDistributorTab = true;
    public $withFranchiseeTab = true;
    public $withShopTab = true;

    public function getTabsId() {
        return 'transfer-panel-tabs';
    }

    public function getTabItems() {
        $items = [];
        if ($this->withDistributorTab) {
            $items[] = $this->getDistributorTab();
        }

        if ($this->withFranchiseeTab) {
            $items[] = $this->getFranchiseeTab();
        }

        if ($this->withShopTab) {
            $items[] = $this->getShopTab();
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

    public function getDistributorTab() {
        if (!isset($this->_tabs['getDistributorTab'])) {
            $this->_tabs['getDistributorTab'] = [
                'label' => Yii::t('app.c2', 'Distributor Transfer'),
                'content' => \backend\modules\Sys\modules\Config\widgets\DistributorTransfer::widget([]),
                'enable' => true,
            ];
        }

        return $this->_tabs['getDistributorTab'];
    }

    public function getFranchiseeTab() {
        if (!isset($this->_tabs['getFranchiseeTab'])) {
            $this->_tabs['getFranchiseeTab'] = [
                'label' => Yii::t('app.c2', 'Franchisee Transfer'),
                'content' => \backend\modules\Sys\modules\Config\widgets\FranchiseeTransfer::widget([]),
                'enable' => true,
            ];
        }

        return $this->_tabs['getFranchiseeTab'];
    }

    public function getShopTab() {
        if (!isset($this->_tabs['getShopTab'])) {
            $this->_tabs['getShopTab'] = [
                'label' => Yii::t('app.c2', 'Shop Transfer'),
                'content' => \backend\modules\Sys\modules\Config\widgets\ShopTransfer::widget([]),
                'enable' => true,
            ];
        }

        return $this->_tabs['getShopTab'];
    }
}