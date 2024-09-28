<?php

namespace common\models\c2\statics;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * FeUserType
 *
 * @author CXJ
 */
class InventoryDeliveryNoteState extends AbstractStaticClass {

    const INIT = 1;
    const PROCESSING = 2;
    const SOLVED = 3;
    const CANCEL = 4;

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
                static::INIT => ['id' => static::INIT, 'label' => Yii::t('app.c2', 'Init')],
                static::PROCESSING => ['id' => static::PROCESSING, 'label' => Yii::t('app.c2', 'Processing')],
                static::SOLVED => ['id' => static::SOLVED, 'label' => Yii::t('app.c2', 'Solved')],
                static::CANCEL => ['id' => static::CANCEL, 'label' => Yii::t('app.c2', 'Cancel')],
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