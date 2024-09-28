<?php

namespace common\models\c2\statics;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * RegistrationSrcType
 *
 * @author ben
 */
class RegistrationSrcType extends AbstractStaticClass {

    const TYPE_DEFAULT = 100;
    const TYPE_WECHAT = 1;
    const TYPE_WECHAT_MINIAPP = 2;
    const TYPE_IOS = 3;
    const TYPE_ANDROID = 4;
    const TYPE_WEB = 5;
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
                static::TYPE_DEFAULT => ['id' => static::TYPE_DEFAULT, 'modelClass' => '\common\models\c2\entity\FeUserProfile', 'label' => Yii::t('app.c2', 'Default')],
                static::TYPE_WECHAT => ['id' => static::TYPE_WECHAT, 'modelClass' => '\common\models\c2\entity\MerchantProfile', 'label' => Yii::t('app.c2', 'Wechat')],
                static::TYPE_WECHAT_MINIAPP => ['id' => static::TYPE_WECHAT_MINIAPP, 'modelClass' => '\common\models\c2\entity\SalesmanProfile', 'label' => Yii::t('app.c2', 'Wechat Mini App')],
                static::TYPE_IOS => ['id' => static::TYPE_IOS, 'modelClass' => '\common\models\c2\entity\CustomerProfile', 'label' => Yii::t('app.c2', 'IOS')],
                static::TYPE_ANDROID => ['id' => static::TYPE_ANDROID, 'modelClass' => '\common\models\c2\entity\CustomerProfile', 'label' => Yii::t('app.c2', 'Android')],
                static::TYPE_WEB => ['id' => static::TYPE_WEB, 'modelClass' => '\common\models\c2\entity\CustomerProfile', 'label' => Yii::t('app.c2', 'Web')],
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

    public static function getModelClass($id) {
        return static::getData($id, 'modelClass');
    }

}
