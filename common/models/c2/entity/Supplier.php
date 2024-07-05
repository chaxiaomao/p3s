<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%supplier}}".
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $label
 * @property string $contact_name
 * @property string $contact_phone
 * @property string $fax
 * @property string $province_id
 * @property string $city_id
 * @property string $district_id
 * @property string $geo_longitude
 * @property string $geo_latitude
 * @property string $geo_marker_color
 * @property string $description
 * @property integer $is_default
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class Supplier extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%supplier}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['province_id', 'city_id', 'district_id', 'position'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['code', 'name', 'label', 'contact_name', 'contact_phone', 'fax', 'geo_longitude', 'geo_latitude', 'geo_marker_color'], 'string', 'max' => 255],
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
            'contact_name' => Yii::t('app.c2', 'Contact Name'),
            'contact_phone' => Yii::t('app.c2', 'Contact Phone'),
            'fax' => Yii::t('app.c2', 'Fax'),
            'province_id' => Yii::t('app.c2', 'Province ID'),
            'city_id' => Yii::t('app.c2', 'City ID'),
            'district_id' => Yii::t('app.c2', 'District ID'),
            'geo_longitude' => Yii::t('app.c2', 'Geo Longitude'),
            'geo_latitude' => Yii::t('app.c2', 'Geo Latitude'),
            'geo_marker_color' => Yii::t('app.c2', 'Geo Marker Color'),
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
     * @return \common\models\c2\query\SupplierQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\SupplierQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

}
