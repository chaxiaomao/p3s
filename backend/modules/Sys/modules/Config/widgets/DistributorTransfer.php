<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30
 * Time: 9:46
 */

namespace backend\modules\Sys\modules\Config\widgets;

use Yii;
use cza\base\widgets\Widget;

class DistributorTransfer extends Widget{
    public function run() {
        return $this->render($this->template, ['model' => Yii::createObject([
            'class' => '\backend\models\c2\form\Config\DistributorTransferForm',
        ])]);
    }
}