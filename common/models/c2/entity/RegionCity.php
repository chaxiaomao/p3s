<?php

namespace common\models\c2\entity;

use Yii;
use common\models\c2\statics\RegionType;
use yii\helpers\ArrayHelper;

class RegionCity extends Region
{

    public function loadDefaultValues($skipIfSet = true)
    {
        parent::loadDefaultValues($skipIfSet);
        $this->type = RegionType::TYPE_CITY;
    }

    public static function find()
    {
        return parent::find()->citys()->orderBy(['position' => SORT_DESC, 'label' => SORT_ASC]);
    }

    public function getDistricts()
    {
        return $this->hasMany(RegionDistrict::className(), ['id' => 'child_id'])
            ->where(['status' => \cza\base\models\statics\EntityModelStatus::STATUS_ACTIVE])
            ->viaTable('{{%region_rs}}', ['parent_id' => 'id']);
    }

    /**
     *
     * @param type $keyField
     * @param type $valField - could be string or alias array
     * @return type
     */
    public function getDistrictHashMap($keyField = 'id', $valField = 'label')
    {
        return ArrayHelper::map($this->getDistricts()->select([$keyField, $valField])->asArray()->all(), $keyField, $valField);
    }

    public function getDistrictsArr()
    {
        $data = [];
        foreach ($this->getDistricts()->all() as $item => $districts) {
            $data[$item] = [
                'name' => $districts->label,
                'pid' => (int)$this->id,
                'id' => (int)$districts->id
            ];
        }
        return $data;
    }

    public static function getCityHashMapByProvince($keyField, $valField, $province_id)
    {
        $cityIds = [];
        $rsModels = RegionRsModel::find()->where(['parent_id' => $province_id])->all();
        if (!empty($rsModels)) {
            foreach ($rsModels as $rsModel) {
                $cityIds[] = $rsModel->child_id;
            }
        }

        $cityHashMap = self::getHashMap('id', 'label', ['in', 'id', $cityIds]);
        return $cityHashMap;
    }
}
