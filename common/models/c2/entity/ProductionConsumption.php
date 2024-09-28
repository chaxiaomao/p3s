<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%production_consumption}}".
 *
 * @property string $id
 * @property string $schedule_id
 * @property string $schedule_item_id
 * @property string $need_product_id
 * @property string $need_product_sku
 * @property string $need_product_name
 * @property string $need_product_label
 * @property string $need_product_value
 * @property double $need_number
 * @property double $need_sum
 * @property double $send_sum
 * @property string $memo
 * @property integer $state
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class ProductionConsumption extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%production_consumption}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schedule_id', 'schedule_item_id', 'need_product_id', 'position'], 'integer'],
            [['need_number', 'need_sum', 'send_sum'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['need_product_sku', 'need_product_name', 'need_product_label', 'need_product_value', 'memo'], 'string', 'max' => 255],
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
            'schedule_id' => Yii::t('app.c2', 'Schedule ID'),
            'schedule_item_id' => Yii::t('app.c2', 'Schedule Item ID'),
            'need_product_id' => Yii::t('app.c2', 'Need Product ID'),
            'need_product_sku' => Yii::t('app.c2', 'Need Product Sku'),
            'need_product_name' => Yii::t('app.c2', 'Need Product Name'),
            'need_product_label' => Yii::t('app.c2', 'Need Product Label'),
            'need_product_value' => Yii::t('app.c2', 'Need Product Value'),
            'need_number' => Yii::t('app.c2', 'Need Number'),
            'need_sum' => Yii::t('app.c2', 'Need Sum'),
            'memo' => Yii::t('app.c2', 'Memo'),
            'state' => Yii::t('app.c2', 'State'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
            'send_sum' => Yii::t('app.c2', 'Send Sum'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\ProductionScheduleItemConsumptionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\ProductionScheduleItemConsumptionQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'need_product_id']);
    }

}
