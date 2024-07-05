<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/7/5
 * Time: 12:09
 */

namespace backend\models\c2\entity;

use common\models\c2\entity\Product;
use Yii;
use yii\helpers\ArrayHelper;

class Material extends Product
{

    // public function rules()
    // {
    //     return ArrayHelper::merge(parent::rules(), [
    //         [['label'], 'required'],
    //     ]);
    // }

    public static function getMixedOptions($keyField, $valField, $condition = '')
    {
        $models = self::find()->where($condition)->all();
        $data = ['' => Yii::t("app.c2", "Select options ..")];
        foreach ($models as $model) {
            $data[$model->id] = $model->name . '(' . $model->label . ')' . $model->value;
        }
        return $data;
    }

}