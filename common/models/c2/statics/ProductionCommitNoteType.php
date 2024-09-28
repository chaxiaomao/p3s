<?php

namespace common\models\c2\statics;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * ConfigType
 *
 * @author ben
 */
class ProductionCommitNoteType extends AbstractStaticClass {

    const PRODUCT_COMMIT = 0;  // load in when demand
    const MIXTURE_COMMIT = 1;  // load in when demand
    const PROCESS_COMMIT = 2;  // load in when config settings init
    
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
                static::PRODUCT_COMMIT => ['id' => static::PRODUCT_COMMIT, 'label' => Yii::t('app.c2', 'Product Commit')],
                static::MIXTURE_COMMIT => ['id' => static::MIXTURE_COMMIT, 'label' => Yii::t('app.c2', 'Mixture Commit')],
                static::PROCESS_COMMIT => ['id' => static::PROCESS_COMMIT, 'label' => Yii::t('app.c2', 'Pre Production Commit')],
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
