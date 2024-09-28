<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30
 * Time: 11:49
 */

namespace common\models\c2\statics;
use Yii;
use yii\helpers\ArrayHelper;

class TransferType extends AbstractStaticClass{
    const DISTRIBUTOR_TRANSFER = 1;
    const FRANCHISEE_TRANSFER = 2;
    const SHOP_TRANSFER = 3;
    const SALESMAN_TRANSFER = 4;

    protected static $_data;

    public static function getData($id = '', $attr = '') {
        if (is_null(static::$_data)) {
            static::$_data = [
                static::DISTRIBUTOR_TRANSFER => ['id' => static::DISTRIBUTOR_TRANSFER, 'label' => Yii::t('app.c2', 'Distributor Transfer')],
                static::FRANCHISEE_TRANSFER => ['id' => static::FRANCHISEE_TRANSFER, 'label' => Yii::t('app.c2', 'Franchisee Transfer')],
                static::SHOP_TRANSFER => ['id' => static::SHOP_TRANSFER, 'label' => Yii::t('app.c2', 'Shop Transfer')],
                static::SALESMAN_TRANSFER => ['id' => static::SALESMAN_TRANSFER, 'label' => Yii::t('app.c2', 'Salesman Transfer')],
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