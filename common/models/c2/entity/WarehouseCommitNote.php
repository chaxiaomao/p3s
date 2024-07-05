<?php

namespace common\models\c2\entity;

use backend\models\c2\entity\rbac\BeUser;
use common\models\c2\statics\WarehouseCommitNoteType;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\helpers\ArrayHelper;
use yii\validators\RequiredValidator;

/**
 * This is the model class for table "{{%warehouse_commit_note}}".
 *
 * @property string $id
 * @property integer $type
 * @property string $note_id
 * @property string $note_code
 * @property string $label
 * @property string $warehouse_id
 * @property string $receiver_name
 * @property string $updated_by
 * @property string $created_by
 * @property string $memo
 * @property integer $state
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class WarehouseCommitNote extends \cza\base\models\ActiveRecord
{
    public $items;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%warehouse_commit_note}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['note_id', 'warehouse_id', 'updated_by', 'created_by', 'position'], 'integer'],
            [['memo'], 'string'],
            [['note_id'], 'required'],
            [['items'], 'validateItems'],
            [['created_at', 'updated_at', 'items'], 'safe'],
            [['type', 'state', 'status'], 'integer', 'max' => 4],
            [['label', 'receiver_name', 'note_code'], 'string', 'max' => 255],
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
            'note_id' => Yii::t('app.c2', 'Note ID'),
            'note_code' => Yii::t('app.c2', 'Code'),
            'label' => Yii::t('app.c2', 'Label'),
            'warehouse_id' => Yii::t('app.c2', 'Warehouse ID'),
            'receiver_name' => Yii::t('app.c2', 'Receiver Name'),
            'updated_by' => Yii::t('app.c2', 'Updated By'),
            'created_by' => Yii::t('app.c2', 'Created By'),
            'memo' => Yii::t('app.c2', 'Memo'),
            'state' => Yii::t('app.c2', 'State'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
        ];
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            BlameableBehavior::className()
        ]);
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\WarehouseCommitNoteQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\WarehouseCommitNoteQuery(get_called_class());
    }

    public function getCreator()
    {
        return $this->hasOne(BeUser::className(), ['id' => 'created_by']);
    }

    /**
     * setup default values
     **/
    public function loadDefaultValues($skipIfSet = true)
    {
        parent::loadDefaultValues($skipIfSet);
    }

    public function getReceiptNote()
    {
        return $this->hasOne(InventoryReceiptNote::className(), ['id' => 'note_id']);
    }

    public function getDeliveryNote()
    {
        return $this->hasOne(InventoryDeliveryNote::className(), ['id' => 'note_id']);
    }

    public function getNoteByType($type)
    {
        if ($type == WarehouseCommitNoteType::TYPE_RECEIPT) {
            return $this->receiptNote;
        }
        if ($type == WarehouseCommitNoteType::TYPE_DELIVERY) {
            return $this->deliveryNote;
        }
    }

    public function getCommitReceiptItems()
    {
        return $this->hasMany(WarehouseCommitReceiptItem::className(), ['commit_id' => 'id']);
    }

    public function getCommitDeliveryItems()
    {
        return $this->hasMany(WarehouseCommitDeliveryItem::className(), ['commit_id' => 'id']);
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

    public function getWarehouse()
    {
        return $this->hasOne(Warehouse::className(), ['id' => 'warehouse_id']);
    }

}
