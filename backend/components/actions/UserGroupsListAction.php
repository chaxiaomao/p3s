<?php

namespace backend\components\actions;

use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\FileHelper;
use yii\helpers\Url;

/**
 * Descriptions
 *
 *
 * @author Ben Bi <ben@cciza.com>
 * @link http://www.cciza.com/
 * @copyright 2014-2016 CCIZA Software LLC
 * @license
 */
class UserGroupsListAction extends \yii\rest\Action {

    public $keyAttribute = 'id';
    public $valueAttribute = 'label';
    public $queryAttribute = 'label';
    public $listMethod = 'getOptionsList';

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

        $params = Yii::$app->request->getQueryParams();
        return $this->prepareDataProvider($params);
    }

    /**
     * Prepares the data provider that should return the requested collection of the models.
     * @return array
     */
    protected function prepareDataProvider($params = []) {
        if (!isset($params['q'])) {
            throw new \yii\web\HttpException(404, 'Require parameter "q"!');
        }
        if (!isset($params['type'])) {
            throw new \yii\web\HttpException(404, 'Require parameter "type"!');
        }

        $data = [];
        $modelClass = $this->modelClass;
        $listModelClass = $modelClass::getModelClassByType($params['type']);
        $listMethod = $this->listMethod;
        if (!is_null($params['q'])) {
            $data['results'] = $listModelClass::$listMethod($this->keyAttribute, $this->valueAttribute, ['like', $this->queryAttribute, $params['q']]);
        } else {
            $data['results'] = $listModelClass::$listMethod($this->keyAttribute, $this->valueAttribute);
        }
        return $data;
    }

}
