<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%product_package_item}}".
 *
 * @property string $id
 * @property string $label
 * @property string $package_id
 * @property string $product_id
 * @property integer $need_number
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class ProductPackageItem extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_package_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['package_id', 'product_id', 'need_number', 'position'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['label'], 'string', 'max' => 255],
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
            'label' => Yii::t('app.c2', 'Label'),
            'package_id' => Yii::t('app.c2', 'Package ID'),
            'product_id' => Yii::t('app.c2', 'Product ID'),
            'need_number' => Yii::t('app.c2', 'Need Number'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\ProductPackageItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\ProductPackageItemQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

    public function getOwner()
    {
        return $this->hasOne(ProductPackage::className(), ['id' => 'package_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    public function getProductStock()
    {
        return $this->hasOne(ProductStock::className(), ['product_id' => 'product_id']);
    }

    public function getOrderItemConsumption()
    {
        return $this->hasOne(OrderItemConsumption::className(), ['need_product_id' => 'product_id']);
    }

}
