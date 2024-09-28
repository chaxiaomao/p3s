<?php

namespace backend\modules\Sys\modules\Config\widgets;

use Yii;
use cza\base\widgets\Widget;

/**
 * Config Widget
 * 
 * @author Ben Bi <ben@cciza.com>
 * @link http://www.cciza.com/
 * @copyright 2014-2016 CCIZA Software LLC
 * @license
 */
class EshopCommissionSettings extends Widget {

    public function run() {
        return $this->render($this->template, ['model' => Yii::createObject([
                        'class' => '\backend\models\c2\form\Config\EshopCommissionSettingsForm',
        ])]);
    }

}
