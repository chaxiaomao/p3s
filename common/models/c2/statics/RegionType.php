<?php

namespace common\models\c2\statics;

use Yii;

/**
 * RegionType
 *
 * @author ben
 */
class RegionType extends AbstractStaticClass
{

    const TYPE_DEFAULT = 0;  // load in when demand
    const TYPE_PROVINCE = 1;  // province
    const TYPE_CITY = 2;  // city
    const TYPE_DISTRICT = 3;  // district

    protected static $_data;

    /**
     *
     * @param type $id
     * @param type $attr
     * @return string|array
     */
    public static function getData($id = '', $attr = '')
    {
        if (is_null(static::$_data)) {
            static::$_data = [
                static::TYPE_DEFAULT => ['id' => static::TYPE_DEFAULT, 'label' => Yii::t('app.c2', 'Default')],
                static::TYPE_PROVINCE => ['id' => static::TYPE_PROVINCE, 'label' => Yii::t('app.c2', 'Province')],
                static::TYPE_CITY => ['id' => static::TYPE_CITY, 'label' => Yii::t('app.c2', 'City')],
                static::TYPE_DISTRICT => ['id' => static::TYPE_DISTRICT, 'label' => Yii::t('app.c2', 'District')],
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

}
