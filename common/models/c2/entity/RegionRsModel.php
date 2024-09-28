<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%region_rs}}".
 *
 * @property string $id
 * @property string $parent_id
 * @property string $child_id
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class RegionRsModel extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%region_rs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'child_id', 'position'], 'integer'],
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
            'parent_id' => Yii::t('app.c2', 'Parent ID'),
            'child_id' => Yii::t('app.c2', 'Child ID'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\RegionRsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\RegionRsQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

}
