<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%measure}}".
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $label
 * @property string $description
 * @property integer $is_default
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class Measure extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%measure}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['position'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['code', 'name', 'label'], 'string', 'max' => 255],
            [['is_default', 'status'], 'integer', 'max' => 4],
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
            'name' => Yii::t('app.c2', 'Name'),
            'label' => Yii::t('app.c2', 'Label'),
            'description' => Yii::t('app.c2', 'Description'),
            'is_default' => Yii::t('app.c2', 'Is Default'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\MeasureQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\MeasureQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

}
