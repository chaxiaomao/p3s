<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/5
 * Time: 12:09
 */

namespace backend\models\c2\entity;

use common\models\c2\entity\Product as BaseModel;
use Yii;
use yii\helpers\ArrayHelper;

class Product extends BaseModel
{

    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['sku'], 'unique'],
        ]);
    }

}