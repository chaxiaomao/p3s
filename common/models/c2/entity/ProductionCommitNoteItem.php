<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%production_commit_note_item}}".
 *
 * @property string $id
 * @property string $note_id
 * @property string $schedule_id
 * @property string $product_id
 * @property string $product_name
 * @property string $product_sku
 * @property string $product_label
 * @property string $product_value
 * @property string $combination_id
 * @property string $combination_name
 * @property string $measure_id
 * @property integer $commit_sum
 * @property string $memo
 * @property integer $state
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class ProductionCommitNoteItem extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%production_commit_note_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schedule_id', 'product_id', 'combination_id', 'measure_id', 'commit_sum', 'position'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['note_id'], 'string', 'max' => 10],
            [['product_name', 'product_sku', 'product_label', 'product_value', 'combination_name', 'memo'], 'string', 'max' => 255],
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
            'note_id' => Yii::t('app.c2', 'Note ID'),
            'schedule_id' => Yii::t('app.c2', 'Schedule ID'),
            'product_id' => Yii::t('app.c2', 'Product ID'),
            'product_name' => Yii::t('app.c2', 'Product Name'),
            'product_sku' => Yii::t('app.c2', 'Product Sku'),
            'product_label' => Yii::t('app.c2', 'Product Label'),
            'product_value' => Yii::t('app.c2', 'Product Value'),
            'combination_id' => Yii::t('app.c2', 'Combination ID'),
            'combination_name' => Yii::t('app.c2', 'Combination Name'),
            'measure_id' => Yii::t('app.c2', 'Measure ID'),
            'commit_sum' => Yii::t('app.c2', 'Commit Sum'),
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
     * @return \common\models\c2\query\ProductionCommitNoteItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\ProductionCommitNoteItemQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

    public function getOwner()
    {
        return $this->hasOne(ProductionCommitNote::className(), ['id' => 'note_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getProductCombination()
    {
        return $this->hasOne(ProductCombination::className(), ['id' => 'combination_id']);
    }

    public function getScheduleItem()
    {
        return $this->hasOne(ProductionScheduleItem::className(), ['id' => 'schedule_item_id']);
    }

    public function getMeasure()
    {
        return $this->hasOne(Measure::className(), ['id' => 'measure_id']);
    }

}
