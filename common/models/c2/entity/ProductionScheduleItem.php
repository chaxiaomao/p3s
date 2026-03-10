<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%production_schedule_item}}".
 *
 * @property string $id
 * @property string $schedule_id
 * @property string $product_id
 * @property string $product_name
 * @property string $product_sku
 * @property string $product_label
 * @property string $product_value
 * @property string $combination_id
 * @property string $combination_name
 * @property string $package_id
 * @property string $package_name
 * @property string $measure_id
 * @property string $pieces
 * @property integer $production_sum
 * @property integer $bad_number
 * @property integer $enter_product_id
 * @property integer $enter_sum
 * @property string $memo
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class ProductionScheduleItem extends \cza\base\models\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%production_schedule_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schedule_id', 'product_id', 'combination_id', 'pieces', 'package_id', 'measure_id', 'production_sum',
                'bad_number', 'position', 'enter_product_id', 'enter_sum'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['product_name', 'product_sku', 'product_label', 'product_value', 'combination_name', 'package_name', 'memo'], 'string', 'max' => 255],
            [['status'], 'integer', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app.c2', 'ID'),
            'schedule_id' => Yii::t('app.c2', 'Schedule ID'),
            'product_id' => Yii::t('app.c2', 'Product ID'),
            'product_name' => Yii::t('app.c2', 'Product Name'),
            'product_sku' => Yii::t('app.c2', 'Product Sku'),
            'product_label' => Yii::t('app.c2', 'Product Label'),
            'product_value' => Yii::t('app.c2', 'Product Value'),
            'combination_id' => Yii::t('app.c2', 'Combination ID'),
            'combination_name' => Yii::t('app.c2', 'Combination Name'),
            'package_id' => Yii::t('app.c2', 'Package ID'),
            'package_name' => Yii::t('app.c2', 'Package Name'),
            'measure_id' => Yii::t('app.c2', 'Measure ID'),
            'production_sum' => Yii::t('app.c2', 'Production Sum'),
            'bad_number' => Yii::t('app.c2', 'Bad Number'),
            'memo' => Yii::t('app.c2', 'Memo'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
            'enter_product_id' => Yii::t('app.c2', 'Entry Product'),
            'enter_sum' => Yii::t('app.c2', 'Entry Sum'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\ProductionScheduleItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\ProductionScheduleItemQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

    public function getOwner()
    {
        return $this->hasOne(ProductionSchedule::className(), ['id' => 'schedule_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getProductCombination()
    {
        return $this->hasOne(ProductCombination::className(), ['id' => 'combination_id']);
    }

    public function getProductPackage()
    {
        return $this->hasOne(ProductPackage::className(), ['id' => 'package_id']);
    }

    public static function getMixedHashMap($keyField = 'product_id', $valField = 'product_name', $condition = '')
    {
        $models = self::find()->where($condition)->all();
        $data = ['' => Yii::t("app.c2", "Select options ..")];
        foreach ($models as $model) {
            $data[$model->$keyField] = $model->$valField . '(' . $model->product_label . ')' . $model->product_value;
        }
        return $data;
    }

    public static function getEnterProductHashMap($condition = [])
    {
        $models = self::find()->where($condition)
            ->with('enterProduct')
            ->all();
        $data = ['' => Yii::t("app.c2", "Select options ..")];
        foreach ($models as $model) {
            $data[$model->enter_product_id] = $model->enterProduct->name . '(' . $model->enterProduct->label . ')' . $model->enterProduct->value;
        }
        return $data;
    }

    public function getEnterProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'enter_product_id']);
    }

    public function getMeasure()
    {
        return $this->hasOne(Measure::className(), ['id' => 'measure_id']);
    }

}
