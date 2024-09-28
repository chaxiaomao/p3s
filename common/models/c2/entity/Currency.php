<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%currency}}".
 *
 * @property string $id
 * @property string $name
 * @property string $label
 * @property string $iso_code
 * @property integer $is_main
 * @property string $convert_rate
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class Currency extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%currency}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['convert_rate'], 'number'],
            [['position'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'label', 'iso_code'], 'string', 'max' => 255],
            [['is_main', 'status'], 'integer', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app.c2', 'ID'),
            'name' => Yii::t('app.c2', 'Name'),
            'label' => Yii::t('app.c2', 'Label'),
            'iso_code' => Yii::t('app.c2', 'Iso Code'),
            'is_main' => Yii::t('app.c2', 'Is Main'),
            'convert_rate' => Yii::t('app.c2', 'Convert Rate'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\CurrencyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\CurrencyQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

}
