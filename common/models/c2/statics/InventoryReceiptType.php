<?php

namespace common\models\c2\statics;

use Yii;

/**
 * InventoryReceiptType
 *
 * @author ben
 */
class InventoryReceiptType extends AbstractStaticClass {

    const TYPE_NORMAL = 1;  // normal
    const TYPE_REJECT = 2;  // reject order
    
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
                static::TYPE_NORMAL => ['id' => static::TYPE_NORMAL, 'label' => Yii::t('app.c2', 'Normal Storage')],
                static::TYPE_REJECT => ['id' => static::TYPE_REJECT, 'label' => Yii::t('app.c2', 'Reject Storage')],
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
