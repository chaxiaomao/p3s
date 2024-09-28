<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%order_item}}".
 *
 * @property string $id
 * @property string $order_id
 * @property string $label
 * @property string $customer_id
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
 * @property integer $pieces
 * @property integer $send_pieces
 * @property integer $product_sum
 * @property integer $produced_number
 * @property string $price
 * @property string $subtotal
 * @property string $memo
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class OrderItem extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'customer_id', 'product_id', 'combination_id', 'package_id', 'measure_id', 'pieces', 'product_sum', 'position'], 'integer'],
            [['price', 'subtotal', 'produced_number', 'send_pieces'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['label', 'product_name', 'product_sku', 'product_label', 'product_value', 'combination_name', 'package_name', 'memo'], 'string', 'max' => 255],
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
            'label' => Yii::t('app.c2', 'Label'),
            'customer_id' => Yii::t('app.c2', 'Customer ID'),
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
            'pieces' => Yii::t('app.c2', 'Pieces'),
            'send_pieces' => Yii::t('app.c2', 'Send Pieces'),
            'product_sum' => Yii::t('app.c2', 'Product Sum'),
            'produced_number' => Yii::t('app.c2', 'Produced Number'),
            'price' => Yii::t('app.c2', 'Price'),
            'subtotal' => Yii::t('app.c2', 'Subtotal'),
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
     * @return \common\models\c2\query\OrderItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\OrderItemQuery(get_called_class());
    }

    /**
     * setup default values
     **/
    public function loadDefaultValues($skipIfSet = true)
    {
        parent::loadDefaultValues($skipIfSet);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getOwner()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    public function getProductCombination()
    {
        return $this->hasOne(ProductCombination::className(), ['id' => 'combination_id']);
    }

    public function getProductPackage()
    {
        return $this->hasOne(ProductPackage::className(), ['id' => 'package_id']);
    }

    public static function getMixedHashMap($keyField, $valField, $condition = '')
    {
        $models = self::find()->where($condition)->all();
        $data = ['' => Yii::t("app.c2", "Select options ..")];
        foreach ($models as $model) {
            $data[$model->product_id] = $model->product_sku . '(' . $model->product_name . ')';
        }
        return $data;
    }

    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    public function getCustomer()
    {
        return $this->hasOne(FeUser::className(), ['id' => 'order_id']);
    }

    public function getMeasure()
    {
        return $this->hasOne(Measure::className(), ['id' => 'measure_id']);
    }

    public function getLastPrice()
    {
        $item = self::find()->where(['customer_id' => $this->customer_id, 'product_id' => $this->product_id])->orderBy('id')->one()->toArray();
        if ($item) {
            return $item['price'];
        }
        return '无';
    }

}
