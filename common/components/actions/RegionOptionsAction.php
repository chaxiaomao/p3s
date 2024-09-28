<?php

namespace common\components\actions;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use common\models\c2\entity\RegionProvince;

/**
 * be used to retrive kartik\widgets\DepDrop sub options
 *
 *
 * @author Ben Bi <ben@cciza.com>
 * @link http://www.cciza.com/
 * @copyright 2014-2016 CCIZA Software LLC
 * @license
 */
class RegionOptionsAction extends \yii\base\Action {

    public $keyAttribute = 'id';
    public $valueAttribute = 'label';
    public $queryAttribute = 'depdrop_parents';
    public $checkAccess;

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
            throw new Exception('Require parameter "depdrop_parents"!');
        }

        $model = RegionProvince::findOne(['id' => $params['depdrop_all_params']['province-id']]);

        $result = [
            'output' => [],
            'seletcted' => "",
        ];

        $result['output'] = $model->getCitys()->select([$this->keyAttribute, 'name' => $this->valueAttribute])->asArray()->all();
//        $result['output'] = $model->getCityOptionsList();
        return $this->controller->asJson($result);
    }

}
