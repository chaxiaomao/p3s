<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%inventory_delivery_note_item}}".
 *
 * @property string $id
 * @property string $note_id
 * @property string $customer_id
 * @property string $product_id
 * @property string $product_name
 * @property string $product_sku
 * @property string $package_id
 * @property string $package_name
 * @property string $combination_id
 * @property string $combination_name
 * @property string $measure_id
 * @property integer $pieces
 * @property integer $product_sum
 * @property string $volume
 * @property string $weight
 * @property string $price
 * @property string $subtotal
 * @property string $memo
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class InventoryDeliveryNoteItem extends \cza\base\models\ActiveRecord
{

    public $is_auto_number;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%inventory_delivery_note_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['note_id', 'customer_id', 'product_id', 'package_id', 'combination_id', 'measure_id', 'pieces', 'product_sum', 'position'], 'integer'],
            [['price', 'subtotal'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['product_name', 'product_sku', 'package_name', 'combination_name', 'volume', 'weight', 'memo'], 'string', 'max' => 255],
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
            'note_id' => Yii::t('app.c2', 'Note ID'),
            'customer_id' => Yii::t('app.c2', 'Customer ID'),
            'product_id' => Yii::t('app.c2', 'Product ID'),
            'product_name' => Yii::t('app.c2', 'Product Name'),
            'product_sku' => Yii::t('app.c2', 'Product Sku'),
            'package_id' => Yii::t('app.c2', 'Package ID'),
            'package_name' => Yii::t('app.c2', 'Package Name'),
            'combination_id' => Yii::t('app.c2', 'Combination ID'),
            'combination_name' => Yii::t('app.c2', 'Combination Name'),
            'measure_id' => Yii::t('app.c2', 'Measure ID'),
            'pieces' => Yii::t('app.c2', 'Pieces'),
            'product_sum' => Yii::t('app.c2', 'Product Sum'),
            'volume' => Yii::t('app.c2', 'Volume'),
            'weight' => Yii::t('app.c2', 'Weight'),
            'price' => Yii::t('app.c2', 'Price'),
            'subtotal' => Yii::t('app.c2', 'Subtotal'),
            'memo' => Yii::t('app.c2', 'Memo'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\InventoryDeliveryNoteItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\InventoryDeliveryNoteItemQuery(get_called_class());
    }

    /**
     * setup default values
     **/
    public function loadDefaultValues($skipIfSet = true)
    {
        parent::loadDefaultValues($skipIfSet);
    }

    public function getOwner()
    {
        return $this->hasOne(InventoryDeliveryNote::className(), ['id' => 'note_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getMeasure()
    {
        return $this->hasOne(Measure::className(), ['id' => 'measure_id']);
    }

    public static function getMixedHashMap($keyField, $valField, $cond)
    {
        $models = self::find()->where($cond)->all();
        $data = ['' => Yii::t("app.c2", "Select options ..")];
        foreach ($models as $model) {
            $data[$model->product_id] = $model->product_sku . '(' . $model->product_name . ')' ;
        }
        return $data;
    }

    public function getProductCombination()
    {
        return $this->hasOne(ProductCombination::className(), ['id' => 'combination_id']);
    }

    public function getProductPackage()
    {
        return $this->hasOne(ProductPackage::className(), ['id' => 'package_id']);
    }

    public function getCustomer()
    {
        return $this->hasOne(FeUser::className(), ['id' => 'customer_id']);
    }

}
