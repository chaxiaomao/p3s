<?php

namespace common\models\c2\entity;

use backend\models\c2\entity\rbac\BeUser;
use common\helpers\CodeGenerator;
use common\models\c2\statics\OrderState;
use common\models\c2\statics\OrderType;
use common\models\c2\statics\ProductType;
use cza\base\models\statics\EntityModelStatus;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;
use yii\validators\RequiredValidator;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property string $id
 * @property string $code
 * @property string $type
 * @property string $label
 * @property string $customer_id
 * @property string $production_date
 * @property string $delivery_date
 * @property string $grand_total
 * @property string $created_by
 * @property string $updated_by
 * @property string $memo
 * @property integer $state
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class Order extends \cza\base\models\ActiveRecord
{
    public $items;
    public $items_amount;

    public $materialItems;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'created_by', 'updated_by', 'position'], 'integer'],
            [['production_date', 'delivery_date', 'created_at', 'updated_at', 'items', 'items_amount'], 'safe'],
            [['grand_total'], 'number'],
            [['items'], 'validateItems'],
            [['code', 'label', 'memo'], 'string', 'max' => 255],
            [['code', 'customer_id',], 'required'],
            [['state', 'status'], 'integer', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app.c2', 'ID'),
            'code' => Yii::t('app.c2', 'Code'),
            'label' => Yii::t('app.c2', 'Label'),
            'customer_id' => Yii::t('app.c2', 'Customer ID'),
            'production_date' => Yii::t('app.c2', 'Production Date'),
            'delivery_date' => Yii::t('app.c2', 'Delivery Date'),
            'grand_total' => Yii::t('app.c2', 'Grand Total'),
            'created_by' => Yii::t('app.c2', 'Created By'),
            'updated_by' => Yii::t('app.c2', 'Updated By'),
            'memo' => Yii::t('app.c2', 'Memo'),
            'state' => Yii::t('app.c2', 'State'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
            'customer_name' => Yii::t('app.c2', 'Customer ID'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\OrderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\OrderQuery(get_called_class());
    }

    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
        if ($this->isNewRecord) {
            $this->code = CodeGenerator::getCodeByDate($this, 'SO');
        }
    }

    public function setItemsTotalAmount()
    {
        if (!empty($this->items)) {
            $num = 0;
            foreach ($this->items as $item) {
                $num += $item->product_sum;
            }
            $this->items_amount = $num;
        }
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
           BlameableBehavior::className()
        ]);
    }

    public function getCreator()
    {
        return $this->hasOne(BeUser::className(), ['id' => 'created_by']);
    }

    public function getUpdator()
    {
        return $this->hasOne(BeUser::className(), ['id' => 'updated_by']);
    }

    public function getCustomer()
    {
        return $this->hasOne(FeUser::className(), ['id' => 'customer_id']);
    }

    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }

    public function loadItems()
    {
        $this->items = $this->materialItems = $this->getOrderItems()->all();
    }

    public function setStateToCancel()
    {
        foreach ($this->getOrderItems()->all() as $item) {
            $item->updateAttributes([
                'status' => EntityModelStatus::STATUS_INACTIVE
            ]);
        }
        foreach ($this->getOrderItemConsumptions()->all() as $item) {
            $item->delete();
        }
        $this->updateAttributes([
            'state' => OrderState::CANCEL
        ]);
    }

    public function setStateToInit()
    {
        // foreach ($this->getOrderItems()->all() as $item) {
        //     $item->updateAttributes([
        //         'status' => EntityModelStatus::STATUS_ACTIVE
        //     ]);
        // }
        $this->updateAttributes([
            'state' => OrderState::INIT
        ]);
    }

    public function setStateToProcessing()
    {
        foreach ($this->getOrderItems()->all() as $item) {
            $item->updateAttributes([
                'status' => EntityModelStatus::STATUS_ACTIVE
            ]);
        }
        $this->updateAttributes([
            'state' => OrderState::PROCESSING
        ]);
    }

    // public function setStateToProcessing()
    // {
    //     $db = Yii::$app->db->beginTransaction();
    //
    //     foreach ($this->orderItems as $orderItem) {
    //         // get product combination items
    //         $productCombination = $orderItem->productCombination;
    //         if (!is_null($productCombination)) {
    //             foreach ($productCombination->combinationItems as $combinationItem) {
    //                 // get product model
    //                 $product = $combinationItem->product;
    //                 if (!is_null($product)) {
    //                     $attributes = [
    //                         'order_id' => $this->id,
    //                         'order_item_id' => $orderItem->id,
    //                         'sale_product_id' => $orderItem->product_id,
    //                         'sale_product_sum' => $orderItem->product_sum,
    //                         'need_product_id' => $product->id,
    //                         'need_product_sku' => $product->sku,
    //                         'need_product_name' => $product->name,
    //                         'need_product_label' => $product->label,
    //                         'need_product_value' => $product->value,
    //                         'need_number' => $combinationItem->need_number,
    //                         'need_sum' => $combinationItem->need_number * $orderItem->product_sum,
    //                         'memo' => "",
    //                     ];
    //                     $consumptionModel = new OrderItemConsumption();
    //                     $consumptionModel->setAttributes($attributes);
    //                     $consumptionModel->save();
    //                 }
    //             }
    //         }
    //
    //         // get product package items
    //         $productPackage = $orderItem->productPackage;
    //         if (!is_null($productPackage)) {
    //             foreach ($productPackage->packageItems as $packageItem) {
    //                 // get product model
    //                 $product = $packageItem->product;
    //                 if (!is_null($product)) {
    //                     $attributes = [
    //                         'order_id' => $this->id,
    //                         'order_item_id' => $orderItem->id,
    //                         'sale_product_id' => $orderItem->product_id,
    //                         'sale_product_sum' => $orderItem->product_sum,
    //                         'need_product_id' => $product->id,
    //                         'need_product_sku' => $product->sku,
    //                         'need_product_name' => $product->name,
    //                         'need_product_label' => $product->label,
    //                         'need_product_value' => $product->value,
    //                         'need_number' => $packageItem->need_number,
    //                         'need_sum' => $packageItem->need_number * $orderItem->pieces,
    //                         'memo' => "",
    //                     ];
    //                     $consumptionModel = new OrderItemConsumption();
    //                     $consumptionModel->setAttributes($attributes);
    //                     $consumptionModel->save();
    //                 }
    //             }
    //         }
    //     }
    //
    //     $this->updateAttributes([
    //         'state' => OrderState::PROCESSING
    //     ]);
    //
    //     $db->commit();
    // }

    public function setStateToSolved()
    {
        foreach ($this->getOrderItemConsumptions()->all() as $item) {
            $item->delete();
        }
        $this->updateAttributes(['state' => OrderState::SOLVED]);
    }

    public function getOrderItemConsumptions()
    {
        return $this->hasMany(OrderItemConsumption::className(), ['order_id' => 'id']);
    }

    public function validateItems($attribute)
    {
        $items = $this->$attribute;

        foreach ($items as $index => $row) {
            $requiredValidator = new RequiredValidator();
            $error = null;
            $requiredValidator->validate($row['product_id'], $error);
            // $requiredValidator->validate($row['combination_id'], $error);
            // $requiredValidator->validate($row['package_id'], $error);
            if (!empty($error)) {
                $key = $attribute . '[' . $index . '][product_id]';
                // $this->addError($key, Yii::t('app.c2', 'Product/Combination/Package not be null.'));
                $this->addError($key, Yii::t('app.c2', '{attribute} can not be empty!', ['attribute' => Yii::t('app.c2', 'Product')]));
            }
            // if (!empty($error)) {
            //     $key = $attribute . '[' . $index . '][combination_id]';
            //     // $this->addError($key, Yii::t('app.c2', 'Product/Combination/Package not be null.'));
            //     $this->addError($key, Yii::t('app.c2', '{attribute} can not be empty!', ['attribute' => Yii::t('app.c2', 'Product Combination')]));
            // }
            // if (!empty($error)) {
            //     $key = $attribute . '[' . $index . '][package_id]';
            //     // $this->addError($key, Yii::t('app.c2', 'Product/Combination/Package not be null.'));
            //     $this->addError($key, Yii::t('app.c2', '{attribute} can not be empty!', ['attribute' => Yii::t('app.c2', 'Product Package')]));
            // }
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
        $grand_total = 0.00;
        if (!empty($this->items)) {
            foreach ($this->items as $item) {
                $product = Product::findOne($item['product_id']);
                $combination = null;
                $package = null;
                $pieces = isset($item['pieces']) ? $item['pieces'] : 0;
                $price = isset($item['price']) ? $item['price'] : 0.00;
                if ($product->type == ProductType::TYPE_MATERIAL) {
                    $product_sum = $item['product_sum'] == '' ? $price : $item['product_sum'];
                    $subtotal = $item['subtotal'] == '' ? $product_sum * $price : $item['subtotal'];
                } else {
                    $combination = ProductCombination::findOne($item['combination_id']);
                    $package = ProductPackage::findOne($item['package_id']);
                    $product_sum = $item['product_sum'] == '' ? $package->product_capacity * $pieces : $item['product_sum'];
                    $subtotal = $item['subtotal'] == '' ? $product_sum * $price : $item['subtotal'];
                }
                $grand_total += $subtotal;
                $attributes = [
                    'label' => isset($item['label']) ? $item['label'] : '',
                    'customer_id' => $this->customer_id,
                    'product_id' => !is_null($product) ? $product->id : 0,
                    'product_name' => !is_null($product) ? $product->name : '',
                    'product_sku' => !is_null($product) ? $product->sku : '',
                    'product_label' => !is_null($product) ? $product->label : '',
                    'product_value' => !is_null($product) ? $product->value : '',
                    'combination_id' => !is_null($combination) ? $combination->id : 0,
                    'combination_name' => !is_null($combination) ? $combination->name : '',
                    'package_id' => !is_null($package) ? $package->id : 0,
                    'package_name' => !is_null($package) ? $package->name : '',
                    'measure_id' => isset($item['measure_id']) ? $item['measure_id'] : 0,
                    'pieces' => $pieces,
                    'product_sum' => $product_sum,
                    'price' => $price,
                    'subtotal' => $subtotal,
                    'memo' => isset($item['memo']) ? $item['memo'] : '',
                    'position' => isset($item['position']) ? $item['position'] : 0,
                    'status' => EntityModelStatus::STATUS_INACTIVE
                ];
                if (isset($item['id']) && $item['id'] == '') {
                    $itemModel = new OrderItem();
                    $itemModel->setAttributes($attributes);
                    $itemModel->link('owner', $this);
                } elseif (isset($item['id'])) {
                    $itemModel = OrderItem::findOne($item['id']);
                    if (!is_null($itemModel)) {
                        $itemModel->updateAttributes($attributes);
                    }
                }
            }
        }

        $this->updateAttributes(['grand_total' => $grand_total]);
        // if ($this->grand_total == '') {
        //     $this->updateAttributes(['grand_total' => $grand_total]);
        // }
    }

    public function beforeDelete()
    {
        foreach ($this->getOrderItems()->all() as $item) {
            $item->delete();
        }
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

}
