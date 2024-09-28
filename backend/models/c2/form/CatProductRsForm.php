<?php

namespace backend\models\c2\form;

use Yii;
use yii\base\Model;
use cza\base\models\ModelTrait;
use yii\helpers\ArrayHelper;

class CatProductRsForm extends Model {

    use ModelTrait;

    public $product_ids = [];
    public $category_id;
    public $entityModel = null;

    public function init() {
        parent::init();
        $this->loadDefaultValues();
    }

    public function loadDefaultValues() {
        $product = \common\models\c2\entity\ProductCategoryRs::find()
            ->where(['category_id' => $this->entityModel->id])
            ->asArray()
            ->all();
        $ids = ArrayHelper::getColumn($product, 'product_id');
        $this->product_ids = $ids ? $ids : [];
    }

    public function save($params, $id) {
        if (empty($params['product_ids'])) {
            \common\models\c2\entity\ProductCategoryRs::deleteAll(['in', 'product_id', $this->product_ids]);
            return true;
        }
        foreach ($params['product_ids'] as $k => $key) {
            if (!in_array($key, $this->product_ids)) {
                $rs = new \common\models\c2\entity\ProductCategoryRs();
                $rs->setAttributes([
                    'product_id' => $key,
                    'category_id' => $id,
                ]);
                $rs->save(false);
            }
        }
        $del = array_diff($this->product_ids, $params['product_ids']);
        \common\models\c2\entity\ProductCategoryRs::deleteAll(['in', 'product_id', $del]);
        return true;
    }

}
