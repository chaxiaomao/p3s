<?php

namespace backend\modules\Database\modules\ProductCategory\widgets;

use common\models\c2\entity\ProductCategoryRs;
use common\models\c2\search\ProductCategoryRsSearch;
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
    public $withProductTab = false;
    public $withFilterTab = false;
    public $params;

    public function getTabItems()
    {
        $items = [];

        if ($this->withTranslationTabs) {
            $items[] = $this->getTranslationTabItems();
        }

        if ($this->withProfileTab) {
            $items[] = $this->getProfileTab();
        }
        if ($this->withProductTab) {
            $items[] = $this->getProductTab();
        }
        if ($this->withFilterTab) {
            $items[] = $this->getFilterTab();
        }

        if ($this->withBaseInfoTab) {
            $items[] = [
                'label' => Yii::t('app.c2', 'Base Information'),
                'content' => $this->controller->renderPartial('_node_base', ['model' => $this->model, 'params' => $this->params,]),
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

    public function getProductTab()
    {
        if (!isset($this->_tabs['PRODUCT_TAB'])) {
            if (!$this->model->isNewRecord) {
                $searchModel = new ProductCategoryRsSearch();
                $searchModel->category_id = $this->params['node']['id'];
                // Yii::info($this->params['node']);
                // Yii::info($this->params);
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $this->_tabs['PRODUCT_TAB'] = [
                    'label' => Yii::t('app.c2', 'Product'),
                    'content' => $this->controller->renderPartial('product_index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                    ]),
                    'enable' => true,
                ];
            } else {
                $this->_tabs['PRODUCT_TAB'] = [
                    'label' => Yii::t('app.c2', 'Product'),
                    'content' => "",
                    'enable' => false,
                ];
            }
        }

        return $this->_tabs['PRODUCT_TAB'];
    }

    public function getFilterTab()
    {
        if (!isset($this->_tabs['FILTER_TAB'])) {
            if (!$this->model->isNewRecord) {
                $this->_tabs['FILTER_TAB'] = [
                    'label' => Yii::t('app.c2', 'Product'),
                    'content' => $this->controller->renderPartial('_cat_product_rs_form', ['model' => new \backend\models\c2\form\CatProductRsForm(['entityModel' => $this->model]), 'params' => $this->params,]),
                    'enable' => true,
                ];
            } else {
                $this->_tabs['FILTER_TAB'] = [
                    'label' => Yii::t('app.c2', 'Product'),
                    'content' => "",
                    'enable' => false,
                ];
            }
        }

        return $this->_tabs['FILTER_TAB'];
    }

}
