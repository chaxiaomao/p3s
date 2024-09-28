<?php

namespace common\models\c2\statics;

use Yii;
use yii\helpers\ArrayHelper;
use kartik\builder\BaseForm;

/**
 * AttributeInputType
 * match to  kartik\builder\BaseForm input type
 *
 * @author ben
 */
class AttributeInputType extends AbstractStaticClass {

    const INPUT_TEXT = 'textInput';

    /**
     * Text area
     */
    const INPUT_TEXTAREA = 'textarea';
    
    const INPUT_RICHTEXT = 'richtext';

    /**
     * Dropdown list allowing single select
     */
    const INPUT_DROPDOWN_LIST = 'dropdownList';

    /**
     * List box allowing multiple select
     */
    const INPUT_LIST_BOX = 'listBox';

    /**
     * Checkbox input
     */
    const INPUT_CHECKBOX = 'checkbox';

    /**
     * Radio input
     */
    const INPUT_RADIO = 'radio';

    /**
     * Checkbox inputs as a list allowing multiple selection
     */
    const INPUT_CHECKBOX_LIST = 'checkboxList';

    /**
     * Radio inputs as a list
     */
    const INPUT_RADIO_LIST = 'radioList';

    /**
     * Bootstrap styled checkbox button group
     */
    const INPUT_CHECKBOX_BUTTON_GROUP = 'checkboxButtonGroup';

    /**
     * Bootstrap styled radio button group
     */
    const INPUT_RADIO_BUTTON_GROUP = 'radioButtonGroup';

    /**
     * Krajee styled multiselect input that allows formatted checkbox list and radio list
     */
    const INPUT_MULTISELECT = 'multiselect';
    const INPUT_WIDGET = 'widget';

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
                static::INPUT_TEXT => ['id' => static::INPUT_TEXT, 'label' => Yii::t('app.c2', 'INPUT TEXT'), 'isMultiple' => false],
                static::INPUT_TEXTAREA => ['id' => static::INPUT_TEXTAREA, 'label' => Yii::t('app.c2', 'INPUT TEXTAREA'), 'isMultiple' => false],
                static::INPUT_RICHTEXT => ['id' => static::INPUT_RICHTEXT, 'label' => Yii::t('app.c2', 'INPUT RICHTEXT'), 'isMultiple' => false],
                static::INPUT_DROPDOWN_LIST => ['id' => static::INPUT_DROPDOWN_LIST, 'label' => Yii::t('app.c2', 'INPUT DROPDOWN LIST'), 'isMultiple' => true],
//                static::INPUT_LIST_BOX => ['id' => static::INPUT_LIST_BOX, 'label' => Yii::t('app.c2', 'INPUT LIST BOX'), 'isMultiple' => true],
//                static::INPUT_CHECKBOX => ['id' => static::INPUT_CHECKBOX, 'label' => Yii::t('app.c2', 'INPUT CHECKBOX'), 'isMultiple' => false],
//                static::INPUT_RADIO => ['id' => static::INPUT_RADIO, 'label' => Yii::t('app.c2', 'INPUT RADIO'), 'isMultiple' => false],
                static::INPUT_CHECKBOX_LIST => ['id' => static::INPUT_CHECKBOX_LIST, 'label' => Yii::t('app.c2', 'INPUT CHECKBOX LIST'), 'isMultiple' => true],
                static::INPUT_RADIO_LIST => ['id' => static::INPUT_RADIO_LIST, 'label' => Yii::t('app.c2', 'INPUT RADIO LIST'), 'isMultiple' => true],
//                static::INPUT_CHECKBOX_BUTTON_GROUP => ['id' => static::INPUT_CHECKBOX_BUTTON_GROUP, 'label' => Yii::t('app.c2', 'INPUT CHECKBOX BUTTON GROUP'), 'isMultiple' => true],
//                static::INPUT_RADIO_BUTTON_GROUP => ['id' => static::INPUT_RADIO_BUTTON_GROUP, 'label' => Yii::t('app.c2', 'INPUT RADIO BUTTON GROUP'), 'isMultiple' => true],
//                static::INPUT_MULTISELECT => ['id' => static::INPUT_MULTISELECT, 'label' => Yii::t('app.c2', 'INPUT MULTISELECT'), 'isMultiple' => true],
//                static::INPUT_WIDGET => ['id' => static::INPUT_WIDGET, 'label' => Yii::t('app.c2', 'INPUT WIDGET'), 'isMultiple' => true],
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

    public static function isMultiple($type) {
        return static::getData($type, 'isMultiple');
    }

}
