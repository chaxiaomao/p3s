<?php

namespace common\models\c2\statics;

use Yii;

/**
 * InventoryReceiptType
 *
 * @author ben
 */
class WarehouseCommitNoteType extends AbstractStaticClass
{

    const TYPE_RECEIPT = 1;  // normal
    const TYPE_DELIVERY = 2;  // reject order

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
                static::TYPE_RECEIPT => ['id' => static::TYPE_RECEIPT, 'label' => Yii::t('app.c2', 'Warehouse Receipt'), 'viewUrl' => 'view-receipts'],
                static::TYPE_DELIVERY => ['id' => static::TYPE_DELIVERY, 'label' => Yii::t('app.c2', 'Warehouse Delivery'), 'viewUrl' => 'view-deliverys'],
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

    public static function getColorLabel($id)
    {
        $label = static::getLabel($id);
        if ($id == static::TYPE_RECEIPT) {
            return '<span class="label label-success">' . $label . '</span>';
        }
        if ($id == static::TYPE_DELIVERY) {
            return '<span class="label label-warning">' . $label . '</span>';
        }
    }

}
