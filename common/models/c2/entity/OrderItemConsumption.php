<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%order_item_consumption}}".
 *
 * @property string $id
 * @property string $order_id
 * @property string $order_item_id
 * @property string $sale_product_id
 * @property integer $sale_product_sum
 * @property integer $production_sum
 * @property string $need_product_id
 * @property string $need_product_sku
 * @property string $need_product_name
 * @property string $need_product_label
 * @property string $need_product_value
 * @property integer $need_number 材料消耗数量
 * @property integer $need_sum 材料消耗总量(sale_product_sum * need_number)
 * @property string $memo
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class OrderItemConsumption extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_item_consumption}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'order_item_id', 'sale_product_id', 'sale_product_sum', 'production_sum', 'need_product_id', 'position'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['need_number', 'need_sum'], 'double'],
            [['need_product_sku', 'need_product_name', 'need_product_label', 'need_product_value', 'memo'], 'string', 'max' => 255],
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
            'order_id' => Yii::t('app.c2', 'Order ID'),
            'order_item_id' => Yii::t('app.c2', 'Order Item ID'),
            'sale_product_id' => Yii::t('app.c2', 'Sale Product ID'),
            'sale_product_sum' => Yii::t('app.c2', 'Sale Product Sum'),
            'production_sum' => Yii::t('app.c2', 'Production Sum'),
            'need_product_id' => Yii::t('app.c2', 'Need Product ID'),
            'need_product_sku' => Yii::t('app.c2', 'Need Product Sku'),
            'need_product_name' => Yii::t('app.c2', 'Need Product Name'),
            'need_product_label' => Yii::t('app.c2', 'Need Product Label'),
            'need_product_value' => Yii::t('app.c2', 'Need Product Value'),
            'need_number' => Yii::t('app.c2', 'Need Number'),
            'need_sum' => Yii::t('app.c2', 'Need Sum'),
            'memo' => Yii::t('app.c2', 'Memo'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
            'order_code' => Yii::t('app.c2', 'Code'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\OrderItemConsumptionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\OrderItemConsumptionQuery(get_called_class());
    }

    /**
     * setup default values
     **/
    public function loadDefaultValues($skipIfSet = true)
    {
        parent::loadDefaultValues($skipIfSet);
    }

    public function getNeedProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'need_product_id']);
    }

    public function getSaleProduct() {
        return $this->hasOne(Product::className(), ['id' => 'sale_product_id']);
    }

    public function getOrderItem()
    {
        return $this->hasOne(OrderItem::className(), ['id' => 'order_item_id']);
    }

    public function getStockStats()
    {
        $product = $this->needProduct;
        if (is_null($product)) {
            return Yii::t('app.c2', 'Product Non Exist');
        }
        $productStock = $product->stock;
        $total_need = 0;
        $items = self::find()->where(['need_product_id' => $this->need_product_id])->all();
        foreach ($items as $item) {
            $total_need += $item->need_sum;
        }
        if ($productStock->number >= $total_need) {
            return '<span class="label label-success">' . Yii::t('app.c2', 'Enough') . '</span>';
        }
        return '<span class="label label-warning">' . Yii::t('app.c2', 'Not Enough') . '</span>';
    }

    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

}
