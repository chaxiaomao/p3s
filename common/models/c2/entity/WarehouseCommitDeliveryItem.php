<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%warehouse_commit_delivery_item}}".
 *
 * @property string $id
 * @property integer $type
 * @property string $label
 * @property string $commit_id
 * @property string $note_id
 * @property string $package_id
 * @property string $package_name
 * @property string $combination_id
 * @property string $combination_name
 * @property string $product_id
 * @property string $product_name
 * @property string $product_sku
 * @property string $product_label
 * @property string $product_value
 * @property string $measure_id
 * @property integer $pieces
 * @property integer $product_sum
 * @property integer $produce_number
 * @property integer $stock_number
 * @property string $memo
 * @property string $state
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class WarehouseCommitDeliveryItem extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%warehouse_commit_delivery_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['commit_id', 'note_id', 'package_id', 'combination_id', 'product_id', 'measure_id', 'pieces', 'product_sum', 'produce_number', 'stock_number', 'position'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['type', 'status', 'state'], 'integer', 'max' => 4],
            [['label', 'package_name', 'combination_name', 'product_name', 'product_sku', 'product_label', 'product_value', 'memo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app.c2', 'ID'),
            'type' => Yii::t('app.c2', 'Type'),
            'label' => Yii::t('app.c2', 'Label'),
            'commit_id' => Yii::t('app.c2', 'Commit ID'),
            'note_id' => Yii::t('app.c2', 'Note ID'),
            'package_id' => Yii::t('app.c2', 'Package ID'),
            'package_name' => Yii::t('app.c2', 'Package Name'),
            'combination_id' => Yii::t('app.c2', 'Combination ID'),
            'combination_name' => Yii::t('app.c2', 'Combination Name'),
            'product_id' => Yii::t('app.c2', 'Product ID'),
            'product_name' => Yii::t('app.c2', 'Product Name'),
            'product_sku' => Yii::t('app.c2', 'Product Sku'),
            'product_label' => Yii::t('app.c2', 'Product Label'),
            'product_value' => Yii::t('app.c2', 'Product Value'),
            'measure_id' => Yii::t('app.c2', 'Measure ID'),
            'pieces' => Yii::t('app.c2', 'Pieces'),
            'product_sum' => Yii::t('app.c2', 'Product Sum'),
            'produce_number' => Yii::t('app.c2', 'Produce Number'),
            'stock_number' => Yii::t('app.c2', 'Stock Number'),
            'memo' => Yii::t('app.c2', 'Memo'),
            'state' => Yii::t('app.c2', 'State'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\WarehouseCommitDeliveryItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\WarehouseCommitDeliveryItemQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

    public function getOwner()
    {
        return $this->hasOne(WarehouseCommitNote::className(), ['id' => 'commit_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getProductPackage()
    {
        return $this->hasOne(ProductPackage::className(), ['id' => 'package_id']);
    }

    public function getProductCombination()
    {
        return $this->hasOne(ProductCombination::className(), ['id' => 'combination_id']);
    }

    public function getProductStock()
    {
        return $this->hasOne(ProductStock::className(), ['product_id' => 'product_id']);
    }

}
