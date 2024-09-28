<?php

namespace common\models\c2\entity;

use Yii;
use common\models\c2\statics\FeUserType;
use cza\base\models\statics\EntityModelStatus;
use common\models\c2\statics\RegionType;
use yii\helpers\ArrayHelper;

class RegionProvince extends Region
{
    public $_data = [];
    public $date_to;

    protected static $_cacheData = [];

    public function loadDefaultValues($skipIfSet = true)
    {
        parent::loadDefaultValues($skipIfSet);
        $this->type = RegionType::TYPE_PROVINCE;
    }

    public static function find()
    {
        return parent::find()->provinces()->orderBy(['position' => SORT_DESC, 'label' => SORT_ASC]);
    }

    public function getCitys()
    {
        return $this->hasMany(RegionCity::className(), ['id' => 'child_id'])
            ->where(['status' => \cza\base\models\statics\EntityModelStatus::STATUS_ACTIVE])
            ->viaTable('{{%region_rs}}', ['parent_id' => 'id']);
    }

    /**
     *
     * @param type $keyField
     * @param type $valField - could be string or alias array
     * @return type
     */
    public function getCityHashMap($keyField = 'id', $valField = 'label') {
        return ArrayHelper::map($this->getCitys()->select([$keyField, $valField])->asArray()->all(), $keyField, $valField);
    }

    public static function getAll()
    {
        if (!isset(static::$_cacheData['all'])) {
            static::$_cacheData['all'] = static::find()->all();
        }
        return static::$_cacheData['all'];
    }

    public static function sort(&$data)
    {
        usort($data, function ($a, $b) {
            $cA = $a['count'];
            $cB = $b['count'];
            if ($cA == $cB) {
                return 0;
            }
            return ($cA < $cB) ? -1 : 1;
        });
    }

    public function getTodayCondition()
    {
        if (!isset($this->_data['todaycondition'])) {
            $this->_data['todaycondition'] = [
                'AND',
                ['between', 'created_at', date('Y-m-d 00:00', strtotime($this->date_to)), date('Y-m-d 23:59', strtotime($this->date_to))]
            ];
        }
        return $this->_data['todaycondition'];
    }

    public function getCityArr()
    {
        $data = [];
        foreach ($this->getCitys()->all() as $item => $city) {
            $data[$item] = [
                'name' => $city->label,
                'pid' => (int)$this->id,
                'id' => (int)$city->id,
                'districtList' => $city->getDistrictsArr()
            ];
        }
        return $data;
    }
}
