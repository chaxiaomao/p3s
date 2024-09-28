<?php

namespace common\models\c2\entity;

use Yii;

/**
 * This is the model class for table "{{%warehouse}}".
 *
 * @property string $id
 * @property string $label
 * @property string $name
 * @property string $code
 * @property string $contact_name
 * @property string $contact_phone
 * @property string $fax
 * @property string $eshop_id
 * @property string $entity_id
 * @property string $entity_class
 * @property integer $country_id
 * @property integer $province_id
 * @property integer $city_id
 * @property string $district_id
 * @property integer $area_id
 * @property string $address
 * @property string $geo_longitude
 * @property string $geo_latitude
 * @property string $geo_marker_color
 * @property integer $state
 * @property integer $status
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 */
class Warehouse extends \cza\base\models\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%warehouse}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['eshop_id', 'entity_id', 'country_id', 'province_id', 'city_id', 'district_id', 'area_id', 'position'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['label', 'name', 'code', 'contact_name', 'contact_phone', 'fax', 'entity_class', 'address', 'geo_longitude', 'geo_latitude', 'geo_marker_color'], 'string', 'max' => 255],
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
            'label' => Yii::t('app.c2', 'Label'),
            'name' => Yii::t('app.c2', 'Name'),
            'code' => Yii::t('app.c2', 'Code'),
            'contact_name' => Yii::t('app.c2', 'Contact Name'),
            'contact_phone' => Yii::t('app.c2', 'Contact Phone'),
            'fax' => Yii::t('app.c2', 'Fax'),
            'eshop_id' => Yii::t('app.c2', 'Eshop ID'),
            'entity_id' => Yii::t('app.c2', 'Entity ID'),
            'entity_class' => Yii::t('app.c2', 'Entity Class'),
            'country_id' => Yii::t('app.c2', 'Country ID'),
            'province_id' => Yii::t('app.c2', 'Province ID'),
            'city_id' => Yii::t('app.c2', 'City ID'),
            'district_id' => Yii::t('app.c2', 'District ID'),
            'area_id' => Yii::t('app.c2', 'Area ID'),
            'address' => Yii::t('app.c2', 'Address'),
            'geo_longitude' => Yii::t('app.c2', 'Geo Longitude'),
            'geo_latitude' => Yii::t('app.c2', 'Geo Latitude'),
            'geo_marker_color' => Yii::t('app.c2', 'Geo Marker Color'),
            'state' => Yii::t('app.c2', 'State'),
            'status' => Yii::t('app.c2', 'Status'),
            'position' => Yii::t('app.c2', 'Position'),
            'created_at' => Yii::t('app.c2', 'Created At'),
            'updated_at' => Yii::t('app.c2', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \common\models\c2\query\WarehouseQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\c2\query\WarehouseQuery(get_called_class());
    }
    
    /**
    * setup default values
    **/
    public function loadDefaultValues($skipIfSet = true) {
        parent::loadDefaultValues($skipIfSet);
    }

}
