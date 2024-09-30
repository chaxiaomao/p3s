<?php

namespace common\models\c2\entity;

use common\models\c2\statics\WarehouseNoteType;
use Yii;

/**
 * This is the model class for table "{{%warehouse_note_item}}".
 *
 * @property string $id
 * @property integer $note_id
 * @property integer $ref_note_id
 * @property integer $product_id
 * @property string $product_name
 * @property string $product_sku
 * @property string $product_label
 * @property string $product_value
 * @property integer $combination_id
 * @property string $combination_name
 * @property integer $measure_id
 * @property integer $package_id
 * @property string $package_name
 * @property integer $pieces
 * @property integer $number
 * @property integer $price
 * @property integer $subtotal
 * @property string $memo
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class WarehouseNoteItem extends \cza\base\models\ActiveRecord
{

    public $item_id;
    public $supplier_id;
    public $code;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%warehouse_note_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['note_id', 'ref_note_id', 'measure_id', 'product_id', 'combination_id', 'package_id', 'pieces', 'number', 'price', 'subtotal', 'position'], 'integer'],
            [['created_at', 'updated_at', 'item_id'], 'safe'],
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
            'note_id' => Yii::t('app.c2', 'Note ID'),
            'ref_note_id' => Yii::t('app.c2', 'Ref Note ID'),
            'product_id' => Yii::t('app.c2', 'Product ID'),
            'product_name' => Yii::t('app.c2', 'Product Name'),
            'product_sku' => Yii::t('app.c2', 'Product Sku'),
            'product_label' => Yii::t('app.c2', 'Product Label'),
            'product_value' => Yii::t('app.c2', 'Product Value'),
            'combination_id' => Yii::t('app.c2', 'Combination ID'),
            'combination_name' => Yii::t('app.c2', 'Combination Name'),
            'measure_id' => Yii::t('app.c2', 'Measure ID'),
            'package_id' => Yii::t('app.c2', 'Package ID'),
            'package_name' => Yii::t('app.c2', 'Package Name'),
            'pieces' => Yii::t('app.c2', 'Pieces'),
            'number' => Yii::t('app.c2', 'Number'),
            'price' => Yii::t('app.c2', 'Price'),
            'subtotal' => Yii::t('app.c2', 'Subtotal'),
            'memo' => Yii::t('app.c2', 'Memo'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
            'warehouse_note_type' => Yii::t('app.c2', 'Warehouse Note Type'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\WarehouseNoteItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\WarehouseNoteItemQuery(get_called_class());
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
        return $this->hasOne(WarehouseNote::className(), ['id' => 'note_id']);
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

    public function getScheduleNoteItems()
    {
        return $this->hasOne(ProductionScheduleItem::className(), ['schedule_id' => 'ref_note_id']);
    }

    public function getMeasure()
    {
        return $this->hasOne(Measure::className(), ['id' => 'measure_id']);
    }

    public function getProductionConsumption()
    {
        return $this->hasOne(ProductionConsumption::className(), ['schedule_id' => 'ref_note_id']);
    }

    public function getDeliveryNote()
    {
        return $this->hasOne(InventoryDeliveryNote::className(), ['id' => 'ref_note_id']);
    }

    public function getReceiptNote()
    {
        return $this->hasOne(InventoryReceiptNote::className(), ['id' => 'ref_note_id']);
    }

    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    public function getReceiptNoteItem()
    {
        return $this->hasOne(InventoryReceiptNoteItem::className(), ['note_id' => 'ref_note_id', 'product_id' => 'product_id']);
    }

    public function getScheduleItem()
    {
        return $this->hasOne(ProductionScheduleItem::className(), ['schedule_id' => 'ref_note_id', 'product_id' => 'product_id']);
    }


    public function isReceipt()
    {
        $warehouseType = $this->owner->type;
        if ($warehouseType == WarehouseNoteType::MIXTURE_RECEIPT
        || $warehouseType == WarehouseNoteType::PRODUCTION
        || $warehouseType == WarehouseNoteType::RECEIPT
        || $warehouseType == WarehouseNoteType::PROCESS_RECEIPT
        // || $warehouseType == WarehouseNoteType::PROCESS_SAB
        ) {
            return true;
        }
        return false;
    }
}
