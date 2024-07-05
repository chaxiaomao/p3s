<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%warehouse_commit_receipt_item}}".
 *
 * @property string $id
 * @property integer $type
 * @property string $label
 * @property string $commit_id
 * @property string $note_id
 * @property string $product_id
 * @property integer $number
 * @property string $memo
 * @property string $state
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class WarehouseCommitReceiptItem extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%warehouse_commit_receipt_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['commit_id', 'note_id', 'product_id', 'position'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['number',], 'double'],
            [['type', 'status', 'state'], 'integer', 'max' => 4],
            [['label', 'memo'], 'string', 'max' => 255],
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
            'product_id' => Yii::t('app.c2', 'Product ID'),
            'number' => Yii::t('app.c2', 'Number'),
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
     * @return \common\models\c2\query\WarehouseCommitReceiptItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\WarehouseCommitReceiptItemQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

    public function getOwner()
    {
        return $this->hasMany(WarehouseCommitNote::className(), ['id' => 'commit_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

}
