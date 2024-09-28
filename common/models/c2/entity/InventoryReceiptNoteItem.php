<?php

namespace common\models\c2\entity;

use common\models\c2\statics\WarehouseNoteType;
use Yii;

/**
 * This is the model class for table "{{%inventory_receipt_note_item}}".
 *
 * @property string $id
 * @property string $note_id
 * @property string $supplier_id
 * @property string $product_id
 * @property string $product_name
 * @property string $product_sku
 * @property string $product_label
 * @property string $product_value
 * @property string $measure_id
 * @property integer $number
 * @property string $price
 * @property string $subtotal
 * @property string $purcharse_order_code
 * @property string $memo
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class InventoryReceiptNoteItem extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%inventory_receipt_note_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['note_id', 'product_id', 'measure_id', 'position', 'supplier_id'], 'integer'],
            [['price', 'subtotal'], 'number'],
            [['number',], 'double'],
            [['created_at', 'updated_at'], 'safe'],
            [['product_name', 'product_sku', 'product_label', 'product_value', 'purcharse_order_code', 'memo'], 'string', 'max' => 255],
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
            'product_id' => Yii::t('app.c2', 'Product ID'),
            'product_name' => Yii::t('app.c2', 'Product Name'),
            'product_sku' => Yii::t('app.c2', 'Product Sku'),
            'product_label' => Yii::t('app.c2', 'Product Label'),
            'product_value' => Yii::t('app.c2', 'Product Value'),
            'measure_id' => Yii::t('app.c2', 'Measure ID'),
            'number' => Yii::t('app.c2', 'Number'),
            'price' => Yii::t('app.c2', 'Price'),
            'subtotal' => Yii::t('app.c2', 'Subtotal'),
            'purcharse_order_code' => Yii::t('app.c2', 'Purcharse Order Code'),
            'memo' => Yii::t('app.c2', 'Memo'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
            'supplier_id' => Yii::t('app.c2', 'Supplier'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\InventoryReceiptNoteItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\InventoryReceiptNoteItemQuery(get_called_class());
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
        return $this->hasOne(InventoryReceiptNote::className(), ['id' => 'note_id']);
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
            $data[$model->product_id] = $model->product_name . '(' . $model->product_label . ')' . $model->product_value;
        }
        return $data;
    }

    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    public function getCommitSum()
    {
        $items = WarehouseNoteItem::find()
            ->select([
                '{{%warehouse_note_item}}.*',
                '{{%warehouse_note}}.type',
            ])

            ->leftJoin(WarehouseNote::tableName(), '{{%warehouse_note_item}}.note_id = {{%warehouse_note}}.id')
            ->where(['{{%warehouse_note}}.type' => WarehouseNoteType::RECEIPT])
            ->where([
                '{{%warehouse_note_item}}.ref_note_id' => $this->note_id,
                'product_id' => $this->product_id,
            ])
            ->orderBy(['{{%warehouse_note_item}}.created_at' => SORT_DESC])
            ->asArray()
            ->all();
        // print_r($items->createCommand()->getRawSql());

        $num = 0;
        foreach ($items as $item) {
            $num += $item['number'];
        }
        return [
            'last_time' => !empty($items) ? $items[0]['created_at'] : '',
            'num' => $num,
        ];
    }

}
