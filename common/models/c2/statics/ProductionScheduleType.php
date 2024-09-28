<?php

namespace common\models\c2\statics;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * FeUserType
 *
 * @author CXJ
 */
class ProductionScheduleType extends AbstractStaticClass {

    const PRODUCT = 1;
    const MIXTURE = 2;
    const PROCESS = 3;

    protected static $_data;

    /**
     * 
     * @param type $id
     * @param type $attr
     * @return string|array
     */
    public static function getData($id = '', $attr = '') {
        if (is_null(static::$_data)) {
            static::$_data = [
                static::PRODUCT => ['id' => static::PRODUCT, 'label' => Yii::t('app.c2', 'Product Schedule')],
                static::MIXTURE => ['id' => static::MIXTURE, 'label' => Yii::t('app.c2', 'Mixture Schedule')],
                static::PROCESS => ['id' => static::PROCESS, 'label' => Yii::t('app.c2', 'Process Schedule')],
            ];
        }
        if ($id !== '' && !empty($attr)) {
            return static::$_data[$id][$attr];
        }
        if ($id !== '' && empty($attr)) {
            return static::$_data[$id];
        }
        return static::$_data;
    }
    
    public static function getLabel($id) {
        return static::getData($id, 'label');
    }

    public static function getHashMap($keyField, $valField) {
        $key = __CLASS__ . Yii::$app->language . $keyField . $valField;
        $data = Yii::$app->cache->get($key);

        if ($data === false) {
            $data = ArrayHelper::map(static::getData(), $keyField, $valField);
            Yii::$app->cache->set($key, $data);
        }

        return $data;
    }

    public static function getProductProcessingLabel()
    {
        return self::getLabel(static::PRODUCT);
    }

    public static function getMixtureProcessingLabel()
    {
        return self::getLabel(static::MIXTURE);
    }

}