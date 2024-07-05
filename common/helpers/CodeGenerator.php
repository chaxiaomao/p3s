<?php

namespace common\helpers;

use Yii;
use common\models\c2\entity\SalesActivity;
use yii\helpers\ArrayHelper;

/**
 * CodeGenerator
 * 
 * @author Ben Bi <jianbinbi@gmail.com>
 */
class CodeGenerator extends \yii\base\Component {

    public static $format = '%1$s%2$s%3$010d';

    public static function getCodeByDate(\yii\db\ActiveRecord $record, $prefix = '') {
        $maxId = $record->find()->max('id') + 1;
        return sprintf('%1$s%2$s%3$d', $prefix, date("Ymd"), $maxId);
    }

}
