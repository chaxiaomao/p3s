<?php

namespace common\models\c2\entity;

use backend\models\c2\entity\rbac\BeUser;
use common\helpers\CodeGenerator;
use common\models\c2\statics\InventoryReceiptNoteState;
use common\models\c2\statics\WarehouseNoteType;
use cza\base\models\statics\EntityModelStatus;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;
use yii\validators\RequiredValidator;

/**
 * This is the model class for table "{{%inventory_receipt_note}}".
 *
 * @property string $id
 * @property integer $type
 * @property string $code
 * @property string $label
 * @property string $warehouse_id
 * @property string $supplier_id
 * @property string $arrival_date
 * @property string $occurrence_date
 * @property string $arrival_number
 * @property string $buyer_name
 * @property string $dept_manager_name
 * @property string $financial_name
 * @property string $receiver_name
 * @property string $grand_total
 * @property string $memo
 * @property string $remote_ip
 * @property string $updated_by
 * @property string $created_by
 * @property integer $state
 * @property integer $status
 * @property integer $position
 * @property string $updated_at
 * @property string $created_at
 */
class InventoryReceiptNote extends \cza\base\models\ActiveRecord
{

    public $items;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%inventory_receipt_note}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['warehouse_id', 'supplier_id', 'updated_by', 'created_by', 'position'], 'integer'],
            [['arrival_date', 'occurrence_date', 'updated_at', 'created_at', 'items'], 'safe'],
            [['grand_total'], 'number'],
            [['items'], 'validateItems'],
            [['memo'], 'string'],
            [['type', 'state', 'status'], 'integer', 'max' => 4],
            [['code', 'label', 'arrival_number', 'buyer_name', 'dept_manager_name', 'financial_name', 'receiver_name', 'remote_ip'], 'string', 'max' => 255],
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
            'code' => Yii::t('app.c2', 'Code'),
            'label' => Yii::t('app.c2', 'Label'),
            'warehouse_id' => Yii::t('app.c2', 'Warehouse ID'),
            'supplier_id' => Yii::t('app.c2', 'Supplier ID'),
            'arrival_date' => Yii::t('app.c2', 'Arrival Date'),
            'occurrence_date' => Yii::t('app.c2', 'Occurrence Date'),
            'arrival_number' => Yii::t('app.c2', 'Arrival Number'),
            'buyer_name' => Yii::t('app.c2', 'Buyer Name'),
            'dept_manager_name' => Yii::t('app.c2', 'Dept Manager Name'),
            'financial_name' => Yii::t('app.c2', 'Financial Name'),
            'receiver_name' => Yii::t('app.c2', 'Receiver Name'),
            'grand_total' => Yii::t('app.c2', 'Grand Total'),
            'memo' => Yii::t('app.c2', 'Memo'),
            'remote_ip' => Yii::t('app.c2', 'Remote Ip'),
            'updated_by' => Yii::t('app.c2', 'Updated By'),
            'created_by' => Yii::t('app.c2', 'Created By'),
            'state' => Yii::t('app.c2', 'State'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'supplier_name' => Yii::t('app.c2', 'Supplier ID'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\InventoryReceiptNoteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\InventoryReceiptNoteQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
        if ($this->isNewRecord) {
            $this->code = CodeGenerator::getCodeByDate($this, 'RN');
            $this->state = InventoryReceiptNoteState::PROCESSING;
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

    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    public function getNoteItems()
    {
        return $this->hasMany(InventoryReceiptNoteItem::className(), ['note_id' => 'id']);
    }

    public function loadItems()
    {
        $this->items = $this->getNoteItems()->all();
    }

    public function validateItems($attribute)
    {
        $items = $this->$attribute;

        foreach ($items as $index => $row) {
            $requiredValidator = new RequiredValidator();
            $error = null;
            $requiredValidator->validate($row['product_id'], $error);
            if (!empty($error)) {
                $key = $attribute . '[' . $index . '][product_id]';
                // $this->addError($key, Yii::t('app.c2', 'Product/Combination/Package not be null.'));
                $this->addError($key, Yii::t('app.c2', '{attribute} can not be empty!', ['attribute' => Yii::t('app.c2', 'Product')]));
            }
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
        $grand_total = 0.00;
        if (!empty($this->items)) {
            foreach ($this->items as $item) {
                $product = Product::findOne($item['product_id']);
                $number = isset($item['number']) ? $item['number'] : 0;
                $price = isset($item['price']) ? $item['price'] : 0.00;
                $subtotal = $item['subtotal'] == '' ? $number * $price : $item['subtotal'];
                $grand_total += $subtotal;
                $attributes = [
                    'supplier_id' => $this->supplier_id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'product_label' => $product->label,
                    'product_value' => $product->value,
                    'measure_id' => isset($item['measure_id']) ? $item['measure_id'] : 0,
                    'number' => $number,
                    'price' => $price,
                    'subtotal' => $subtotal,
                    'purcharse_order_code' => $this->code,
                    'memo' => isset($item['memo']) ? $item['memo'] : '',
                    'position' => isset($item['position']) ? $item['position'] : 0,
                ];
                if (isset($item['id']) && $item['id'] == '') {
                    $itemModel = new InventoryReceiptNoteItem();
                    $itemModel->setAttributes($attributes);
                    $itemModel->link('owner', $this);
                } elseif (isset($item['id'])) {
                    $itemModel = InventoryReceiptNoteItem::findOne($item['id']);
                    if (!is_null($itemModel)) {
                        $itemModel->updateAttributes($attributes);
                    }
                }
            }
        }
        if ($this->grand_total == '') {
            $this->updateAttributes(['grand_total' => $grand_total]);
        }
    }

    public function setStateToCancel()
    {
        foreach ($this->getNoteItems()->all() as $item) {
            $item->updateAttributes([
                'status' => EntityModelStatus::STATUS_INACTIVE
            ]);
        }
        $this->updateAttributes(['state' => InventoryReceiptNoteState::CANCEL]);
    }

    public function setStateToProcessing()
    {
        foreach ($this->getNoteItems()->all() as $item) {
            $item->updateAttributes([
                'status' => EntityModelStatus::STATUS_ACTIVE
            ]);
        }
        $this->updateAttributes(['state' => InventoryReceiptNoteState::PROCESSING]);
    }

    public function setStateToSolved()
    {
        $this->updateAttributes(['state' => InventoryReceiptNoteState::SOLVED]);
    }

    public function beforeDelete()
    {
        foreach ($this->getNoteItems()->all() as $item) {
            $item->delete();
        }
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public function getWarehouseNoteItemsLog()
    {
        $models = WarehouseNote::find()->where(['ref_note_id' => $this->id, 'type' => WarehouseNoteType::RECEIPT])->all();
        $noteItems = [];
        foreach ($models as $model) {
            if ($model->noteItems) {
                foreach ($model->noteItems as $noteItem) {
                    $noteItems[] = $noteItem;
                }
            }
        }
        return $noteItems;
    }

}
