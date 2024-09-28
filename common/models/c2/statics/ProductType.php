<?php

namespace common\models\c2\statics;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * FeUserType
 *
 * @author cjh
 */
class ProductType extends AbstractStaticClass {

    const TYPE_MATERIAL = 1;
    const TYPE_PRODUCT = 2;

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
                static::TYPE_MATERIAL => ['id' => static::TYPE_MATERIAL, 'label' => Yii::t('app.c2', 'Material')],
                static::TYPE_PRODUCT => ['id' => static::TYPE_PRODUCT, 'label' => Yii::t('app.c2', 'Product')],
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

    public static function getMaterial()
    {
        return static::getLabel(self::TYPE_MATERIAL);
    }

    public static function getProduct()
    {
        return static::getLabel(self::TYPE_PRODUCT);
    }

}