<?php

namespace common\components\actions;

use common\models\c2\entity\OrderItem;
use common\models\c2\entity\Product;
use common\models\c2\entity\ProductModel;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\FileHelper;
use yii\helpers\Url;

/**
 * Get product skus according to product id
 * be used to retrive kartik\widgets\DepDrop sub options
 *
 *
 * @author Ben Bi <ben@cciza.com>
 * @link http://www.cciza.com/
 * @copyright 2014-2016 CCIZA Software LLC
 * @license
 */
class ProductAdditionOptionsAction extends \yii\base\Action {

    public $keyAttribute = 'id';
    public $valueAttribute = 'label';
    public $queryAttribute = 'depdrop_parents';
    public $checkAccess;
    public $withPrice = false;

    /**
     * @var callable a PHP callable that will be called to prepare a data provider that
     * should return a collection of the models. If not set, [[prepareDataProvider()]] will be used instead.
     * The signature of the callable should be:
     *
     * ```php
     * function ($action) {
     *     // $action is the action object currently running
     * }
     * ```
     *
     * The callable should return an instance of [[ActiveDataProvider]].
     */

    /**
     * @return array
     */
    public function run() {
        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id);
        }

        $params = Yii::$app->request->post();
        return $this->prepareDataProvider($params);
    }

    /**
     * Prepares the data provider that should return the requested collection of the models.
     * @return array
     */
    protected function prepareDataProvider($params = []) {
        if (!isset($params['depdrop_all_params'])) {
            throw new \Exception('Require parameter "depdrop_all_params"!');
        }
        if (!isset($params['depdrop_parents'])) {
            throw new \Exception('Require parameter "depdrop_parents"!');
        }
        $customer_id = isset($params['customer_id']) ? $params['customer_id'] : 0;
        $product_id = $params['depdrop_all_params']['product_id'];
        $model = Product::findOne(['id' => $product_id]);

        $result = [
            'output' => [],
            'seletcted' => "",
        ];

        $options = [];
        foreach ($model->combinations as $item) {
            $options[] = [
                'id' => $item->id,
                'name' =>  $item->name . '(库存:' . $item->stock . ')'
            ];
        }
        $result['output']['combination'] = $options;

        $options = [];
        foreach ($model->packages as $item) {
            $options[] = [
                'id' => $item->id,
                'name' =>  $item->name
            ];
        }
        $result['output']['product_name'] = $model->sku . '(' . $model->name . ')';
        $result['output']['package'] = $options;
        $result['output']['last_price'] = 0.000;

        if ($customer_id) {
            $item = OrderItem::find()->where(['customer_id' => $customer_id, 'product_id' => $product_id])->orderBy(['id' => SORT_DESC])->one();
            if ($item) {
                $result['output']['last_price'] = $item->price;
            }
        }

        return $this->controller->asJson($result);
    }

}
