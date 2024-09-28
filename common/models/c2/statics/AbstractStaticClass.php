<?php

namespace common\models\c2\statics;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * AbstractStaticClass
 *
 * @author ben
 */
abstract class AbstractStaticClass
{

    protected static $_data;

    /**
     * for override
     * @param type $id
     * @param type $attr
     * @return string|array
     */
    public static function getData($id = '', $attr = '')
    {
        if (is_null(static::$_data)) {
            static::$_data = [
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

    public static function getLabel($id)
    {
        return static::getData($id, 'label');
    }

    public static function getHashMap($keyField, $valField)
    {
        $key = static::class . Yii::$app->language . $keyField . $valField;
        $data = Yii::$app->cache->get($key);

        if ($data === false) {
            $data = ArrayHelper::map(static::getData(), $keyField, $valField);
            Yii::$app->cache->set($key, $data);
        }

        return $data;
    }

}
