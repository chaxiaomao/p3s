<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\components\rest;

use Yii;

/**
 * Description of ApiResult
 *
 * @author ben <bennybi@qq.com>
 */
class ApiResult extends \yii\base\BaseObject {

    public $error = false;
    public $code = '';
    public $data = [];

    public function getMessage() {
        return isset($this->data['error']) ? $this->data['error']->message : Yii::t('app.c2', 'Unknow error triggered!');
    }
}
