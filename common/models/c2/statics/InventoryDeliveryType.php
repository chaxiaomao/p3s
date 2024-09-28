<?php

namespace common\models\c2\statics;

use Yii;

/**
 * InventoryDeliveryType
 *
 * @author ben
 */
class InventoryDeliveryType extends AbstractStaticClass {

    const TYPE_NORMAL = 1;  // normal
    const TYPE_WRITE_OFF = 2;  // write off
    
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
                static::TYPE_NORMAL => ['id' => static::TYPE_NORMAL, 'label' => Yii::t('app.c2', 'Normal Delivery')],
                static::TYPE_WRITE_OFF => ['id' => static::TYPE_WRITE_OFF, 'label' => Yii::t('app.c2', 'Write Off')],
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
