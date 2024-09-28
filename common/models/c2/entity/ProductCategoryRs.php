<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%product_category_rs}}".
 *
 * @property string $id
 * @property string $product_id
 * @property string $category_id
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class ProductCategoryRs extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product_category_rs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'category_id', 'position'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
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
            'product_id' => Yii::t('app.c2', 'Product ID'),
            'category_id' => Yii::t('app.c2', 'Category ID'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\ProductCategoryRsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\ProductCategoryRsQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

}
