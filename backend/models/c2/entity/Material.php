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

    public function rules()
    {
        return [
            [['low_price', 'sales_price', 'cost_price', 'market_price'], 'number'],
            [['supplier_id', 'currency_id', 'measure_id', 'sold_count', 'warehouse_id', 'created_by', 'updated_by', 'position'], 'integer'],
            [['summary', 'description'], 'string'],
            [['released_at', 'created_at', 'updated_at', 'category_ids'], 'safe'],
            [['type', 'is_released', 'status'], 'integer', 'max' => 4],
            [['seo_code', 'sku', 'name', 'label', 'value'], 'string', 'max' => 255],
            [['sku', 'name',], 'required',],
            // [['sku',], 'unique',],
            [['stock',], 'double',],
        ];
    }

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