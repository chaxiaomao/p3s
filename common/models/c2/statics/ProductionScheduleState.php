<?php

namespace common\models\c2\statics;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * FeUserType
 *
 * @author CXJ
 */
class ProductionScheduleState extends AbstractStaticClass {

    const INIT = 1;
    const COMMIT = 2;
    const CALCULATION = 3;
    const FINISH = 4;
    const ALL_SEND = 0;
    const TERMINATION = -1;

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
                static::COMMIT => ['id' => static::COMMIT, 'label' => Yii::t('app.c2', 'Schedule Commit')],
                static::CALCULATION => ['id' => static::CALCULATION, 'label' => Yii::t('app.c2', 'Schedule Calculated')],
                static::FINISH => ['id' => static::FINISH, 'label' => Yii::t('app.c2', 'Finish')],
                static::ALL_SEND => ['id' => static::ALL_SEND, 'label' => Yii::t('app.c2', 'All Send Commit')],
                static::TERMINATION => ['id' => static::TERMINATION, 'label' => Yii::t('app.c2', 'Schedule Termination')],
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