<?php

namespace common\models\c2\statics;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * AttributeType
 *
 * @author ben
 */
class AttributeType extends AbstractStaticClass {

    const TYPE_PRODUCT = 1;

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
                static::TYPE_PRODUCT => ['id' => static::TYPE_PRODUCT, 'label' => Yii::t('app.c2', 'Product Attribute')],
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
