<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/31
 * Time: 16:24
 */

namespace common\models\c2\entity;

use Yii;
use common\models\c2\statics\RegionType;
use yii\helpers\ArrayHelper;

class RegionDistrict extends Region
{
    public function loadDefaultValues($skipIfSet = true)
    {
        parent::loadDefaultValues($skipIfSet);
        $this->type = RegionType::TYPE_DISTRICT;
    }

    public static function find()
    {
        return parent::find()->districts()->orderBy(['position' => SORT_DESC, 'label' => SORT_ASC]);
    }

}