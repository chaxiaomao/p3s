<?php

namespace common\models\c2\statics;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * FeUserType
 *
 * @author CXJ
 */
class WarehouseNoteType extends AbstractStaticClass {

    const RECEIPT = 1;
    const PRODUCTION = 2;
    const MIXTURE_SEND = 3;
    const MIXTURE_RECEIPT = 4;
    const PROCESS_RECEIPT = 5;
    const DELIVERY = 6;
    const PROCESS_SAB = 7;
    const MODIFY_BY_USER = 0;

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
                static::RECEIPT => ['id' => static::RECEIPT, 'label' => Yii::t('app.c2', 'Warehouse Inventory Receipt')],
                static::DELIVERY => ['id' => static::DELIVERY, 'label' => Yii::t('app.c2', 'Warehouse Inventory Delivery')],
                static::PRODUCTION => ['id' => static::PRODUCTION, 'label' => Yii::t('app.c2', 'Warehouse Production Receipt')],
                static::MIXTURE_SEND => ['id' => static::MIXTURE_SEND, 'label' => Yii::t('app.c2', 'Warehouse Mixture Send')],
                static::MIXTURE_RECEIPT => ['id' => static::MIXTURE_RECEIPT, 'label' => Yii::t('app.c2', 'Warehouse Mixture Receipt')],
                static::PROCESS_RECEIPT => ['id' => static::PROCESS_RECEIPT, 'label' => Yii::t('app.c2', 'Warehouse Process Receipt')],
                static::PROCESS_SAB => ['id' => static::PROCESS_SAB, 'label' => Yii::t('app.c2', 'Warehouse Process Mixture Send')],
                static::MODIFY_BY_USER => ['id' => static::MODIFY_BY_USER, 'label' => Yii::t('app.c2', 'Modify By User')],
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

}